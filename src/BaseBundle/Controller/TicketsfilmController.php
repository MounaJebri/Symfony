<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\Ticketsfilm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ticketsfilm controller.
 *
 * @Route("ticketsfilm")
 */
class TicketsfilmController extends Controller
{
    /**
     * Lists all ticketsfilm entities.
     *
     * @Route("/", name="ticketsfilm_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ticketsfilms = $em->getRepository('BaseBundle:Ticketsfilm')->findAll();
        return $this->render('ticketsfilm/index.html.twig', array(
            'ticketsfilms' => $ticketsfilms,
        ));
    }

    /**
     * Creates a new ticketsfilm entity.
     *
     * @Route("/new", name="ticketsfilm_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ticketsfilm = new Ticketsfilm();
        $form = $this->createForm('BaseBundle\Form\TicketsfilmType', $ticketsfilm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticketsfilm);
            $em->flush();

            return $this->redirectToRoute('ticketsfilm_show', array('id' => $ticketsfilm->getId()));
        }

        return $this->render('ticketsfilm/new.html.twig', array(
            'ticketsfilm' => $ticketsfilm,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ticketsfilm entity.
     *
     * @Route("/{id}", name="ticketsfilm_show")
     * @Method("GET")
     */
    public function showAction(Ticketsfilm $ticketsfilm)
    {
        $deleteForm = $this->createDeleteForm($ticketsfilm);

        return $this->render('ticketsfilm/show.html.twig', array(
            'ticketsfilm' => $ticketsfilm,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ticketsfilm entity.
     *
     * @Route("/{id}/edit", name="ticketsfilm_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ticketsfilm $ticketsfilm)
    {
        $deleteForm = $this->createDeleteForm($ticketsfilm);
        $editForm = $this->createForm('BaseBundle\Form\TicketsfilmType', $ticketsfilm);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticketsfilm_edit', array('id' => $ticketsfilm->getId()));
        }

        return $this->render('ticketsfilm/edit.html.twig', array(
            'ticketsfilm' => $ticketsfilm,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ticketsfilm entity.
     *
     * @Route("/{id}", name="ticketsfilm_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ticketsfilm $ticketsfilm)
    {
        $form = $this->createDeleteForm($ticketsfilm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticketsfilm);
            $em->flush();
        }

        return $this->redirectToRoute('ticketsfilm_index');
    }

    /**
     * Creates a form to delete a ticketsfilm entity.
     *
     * @param Ticketsfilm $ticketsfilm The ticketsfilm entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ticketsfilm $ticketsfilm)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ticketsfilm_delete', array('id' => $ticketsfilm->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
