<?php

namespace MuseeBundle\Controller;
use MuseeBundle\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Visite controller.
 *
 */
class VisiteController extends Controller
{
    /**
     * Lists all visite entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $visites = $em->getRepository('MuseeBundle:Visite')->findAll();

        return $this->render('visite/index.html.twig', array(
            'visites' => $visites,
        ));
    }

    /**
     * Creates a new visite entity.
     *
     */
    public function newAction(Request $request)
    {
        $visite = new Visite();
        $form = $this->createForm('MuseeBundle\Form\VisiteType', $visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($visite);
            $em->flush();

            return $this->redirectToRoute('visite_show', array('idVisite' => $visite->getIdvisite()));

            //return new Response("Votre visite a été reserver");

        }

        return $this->render('visite/new.html.twig', array(
            'visite' => $visite,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a visite entity.
     *
     */
    public function showAction(Visite $visite)
    {
        $deleteForm = $this->createDeleteForm($visite);

        return $this->render('visite/show.html.twig', array(
            'visite' => $visite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing visite entity.
     *
     */
    public function editAction(Request $request, Visite $visite)
    {
        $deleteForm = $this->createDeleteForm($visite);
        $editForm = $this->createForm('MuseeBundle\Form\VisiteType', $visite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('visite_edit', array('idVisite' => $visite->getIdvisite()));
        }

        return $this->render('visite/edit.html.twig', array(
            'visite' => $visite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a visite entity.
     *
     */
    public function deleteAction(Request $request, Visite $visite)
    {
        $form = $this->createDeleteForm($visite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($visite);
            $em->flush();
        }

        return $this->redirectToRoute('visite_index');
    }

    /**
     * Creates a form to delete a visite entity.
     *
     * @param Visite $visite The visite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Visite $visite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('visite_delete', array('idVisite' => $visite->getIdvisite())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function allAction(Request $request){
        $visites=$this->getDoctrine()->getManager()->getRepository('MuseeBundle:Visite')->findAll();
        $serializer= new serializer([new objectNormalizer()]);
        $formatted=$serializer->normalize($visites);
        return new JsonResponse($formatted);
    }
    public function addAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $visite = new Visite();
        $date = new \DateTime($request->get('date')) ;
        $date1 = new \DateTime($request->get('hDebut')) ;
        $date2 = new \DateTime($request->get('hFin')) ;
        $visite->setDate($date);
        $visite->setHDebut($date1);
        $visite->setHFin($date2);
        $visite->setPrix($request->get('prix'));
        //$visite->setIdGuide($request->get('idGuide'));
        $guide = $em->getRepository('MuseeBundle:Guide')->findOneBy(array('id'=>$request->get('idGuide'))) ;
        $visite->setIdGuide($guide);

        $em->persist($visite);
        $em->flush();
        $serializer=new Serializer([new ObjectNormalizer()]);
        $formatted=$serializer->normalize($visite);
        return new JsonResponse($formatted);
    }

//    public function MuseeNewAction()
//    {
//        return $this->render('visite/new.html.twig');
//    }


}

