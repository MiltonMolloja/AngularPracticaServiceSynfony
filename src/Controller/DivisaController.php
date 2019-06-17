<?php

namespace App\Controller;

use App\Entity\Divisa;
use App\Form\DivisaType;
use App\Repository\DivisaRepository;
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
 * @Route("/divisa")
 */
class DivisaController extends AbstractController
{
    /**
     * @Route("/", name="divisa_index", methods={"GET"})
     */
    public function index(DivisaRepository $divisaRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $divisas = $em->getRepository('App:Divisa')->findAll();

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($divisas, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/new", name="divisa_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        //recupero atributos
        $data = json_decode($request->getContent(), true);
        $divisa = new Divisa();
        $divisa->setCompra($data['compra']);        
        $divisa->setVenta($data['venta']);
        $divisa->setMontoRecibido($data['montoRecibido']);
        $divisa->setMontoEntregado($data['montoEntregado']);
        $divisa->setTipoCambio($data['tipoCambio']);
        $fecha = new \DateTime($data['fecha']);
        $divisa->setFecha($fecha);

        //Se Modifico El controlador para el Alta de Entidad Moneda  Sin Cliente
        //$em = $this->getDoctrine()->getManager();

        $clienteArray= $data['cliente'];
        $idCliente = $clienteArray['id'];
        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository("App:Cliente")->find($idCliente);
        $divisa->setCliente($cliente);


        $em->persist($divisa);
        $em->flush();


        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);

    }

    /**
     * @Route("/{id}", name="divisa_show", methods={"GET"})
     */
    public function show(Divisa $divisa): Response
    {
        return $this->render('divisa/show.html.twig', [
            'divisa' => $divisa,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="divisa_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Divisa $divisa): Response
    {
        $form = $this->createForm(DivisaType::class, $divisa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('divisa_index', [
                'id' => $divisa->getId(),
            ]);
        }

        return $this->render('divisa/edit.html.twig', [
            'divisa' => $divisa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="divisa_delete", methods={"DELETE"})
     */
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $divisa = $em->getRepository('App:Divisa')->find($id);
        if (!$divisa){
            throw $this->createNotFoundException('id incorrecta');
        }
        $em->remove($divisa);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }
}
