<?php

namespace App\Controller;

use App\Entity\Mensaje;
use App\Form\MensajeType;
use App\Repository\MensajeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/*AGREGADOs*/
use Symfony\Component\Serializer\Serializer; 
use Symfony\Component\Serializer\Encoder\JsonEncoder; 
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer; 
/*AGREGADOs*/

/**
 * @Route("/mensaje")
 */
class MensajeController extends AbstractController
{
    /**
     * @Route("/", name="mensaje_index", methods={"GET"})
     */
    public function index(MensajeRepository $mensajeRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $mensajes = $em->getRepository('App:Mensaje')->findAll();

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($mensajes, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;       
    }

    /**
     * @Route("/new", name="mensaje_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        //recupero atributos
        $data = json_decode($request->getContent(), true);
        $mensaje = new Mensaje();
        $mensaje->setDesde($data['desde']);
        $mensaje->setPara($data['para']);
        $mensaje->setTexto($data['texto']);
        $fecha = new \DateTime($data['fecha']);
        $mensaje->setFecha($fecha);

        //confecciono una entidad empresa para asignar a mensaje
        $empresaArray= $data['empresa'];
        $idEmpresa = $empresaArray['id'];
        $em = $this->getDoctrine()->getManager();
        $empresa = $em->getRepository("App:Empresa")->find($idEmpresa);
        $mensaje->setEmpresa($empresa);

        $em->persist($mensaje);
        $em->flush();

        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    /**
     * @Route("/{id}", name="mensaje_show", methods={"GET"})
     */
    public function show(Mensaje $mensaje): Response
    {
        return $this->render('mensaje/show.html.twig', [
            'mensaje' => $mensaje,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mensaje_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $em = $this->getDoctrine()->getManager();
        $mensaje = $em->getRepository('App:Mensaje')->find($id);

        $mensaje->setDesde($data['desde']);
        $mensaje->setPara($data['para']);
        $mensaje->setTexto($data['texto']);
        $fecha = new \DateTime($data['fecha']);
        $mensaje->setFecha($fecha);

        
        //recupero la entidad empresa de la BD que se corresponde con la id
        //que se recibe en formato JSON y le asigno a la propiedad empresa de mensaje.
        $empresaArray= $data['empresa'];
        $idEmpresa = $empresaArray['id'];
        $empresa = $em->getRepository("App:Empresa")->find($idEmpresa);
        $mensaje->setEmpresa($empresa);
        

        //guardo en la BD la entidad mensaje modificada.
        $em->persist($mensaje);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }

    /**
     * @Route("/{id}", name="mensaje_delete", methods={"DELETE"})
     */
    public function delete($id): Response
    //public function delete(Request $request, Mensaje $mensaje): Response
    {
        $em = $this->getDoctrine()->getManager();
        $mensaje = $em->getRepository('App:Mensaje')->find($id);
        if (!$mensaje){
            throw $this->createNotFoundException('id incorrecta');
        }
        $em->remove($mensaje);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }
}
