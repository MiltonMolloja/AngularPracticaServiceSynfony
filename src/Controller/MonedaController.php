<?php

namespace App\Controller;

use App\Entity\Moneda;
use App\Form\Moneda1Type;
use App\Repository\MonedaRepository;
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
 * @Route("/moneda")
 */
class MonedaController extends AbstractController
{
    /**
     * @Route("/", name="moneda_index", methods={"GET"})
     */
    public function index(MonedaRepository $monedaRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $monedas = $em->getRepository('App:Moneda')->findAll();

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $response = new Response();
        $response->setContent($serializer->serialize($monedas, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/new", name="moneda_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        //recupero atributos
        $data = json_decode($request->getContent(), true);
        $moneda = new Moneda();
        $moneda->setCompra($data['compra']);
        $moneda->setVenta($data['venta']);
        $moneda->setMontoRecibido($data['montoRecibido']);
        $moneda->setMontoEntregado($data['montoEntregado']);
        $moneda->setTipoCambio($data['tipoCambio']);
        $fecha = new \DateTime($data['fecha']);
        $moneda->setFecha($fecha);

        //confecciono una entidad moneda para asignar a moneda
        $monedaArray= $data['moneda'];
        $idMoneda = $empresaArray['id'];
        $em = $this->getDoctrine()->getManager();
        $moneda = $em->getRepository("App:Moneda")->find($idMoneda);
        $moneda->setMoneda($moneda);

        $em->persist($moneda);
        $em->flush();

        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);

    }

    /**
     * @Route("/{id}", name="moneda_show", methods={"GET"})
     */
    public function show(Moneda $moneda): Response
    {
        return $this->render('moneda/show.html.twig', [
            'moneda' => $moneda,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="moneda_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Moneda $moneda): Response
    {
        $form = $this->createForm(Moneda1Type::class, $moneda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('moneda_index', [
                'id' => $moneda->getId(),
            ]);
        }

        return $this->render('moneda/edit.html.twig', [
            'moneda' => $moneda,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="moneda_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Moneda $moneda): Response
    {
        $em = $this->getDoctrine()->getManager();
        $moneda = $em->getRepository('App:Moneda')->find($id);
        if (!$moneda){
            throw $this->createNotFoundException('id incorrecta');
        }
        $em->remove($moneda);
        $em->flush();
        $result['status'] = 'ok';
        return new Response(json_encode($result), 200);
    }
}
