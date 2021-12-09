<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\Ticketsevent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ticketsevent controller.
 *
 * @Route("ticketsevent")
 */
class TicketseventController extends Controller
{
    /**
     * Lists all ticketsevent entities.
     *
     * @Route("/", name="ticketsevent_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ticketsevents = $em->getRepository('BaseBundle:Ticketsevent')->findAll();

        return $this->render('ticketsevent/index.html.twig', array(
            'ticketsevents' => $ticketsevents,
        ));
    }

    /**
     * Creates a new ticketsevent entity.
     *
     * @Route("/new", name="ticketsevent_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ticketsevent = new Ticketsevent();
        $form = $this->createForm('BaseBundle\Form\TicketseventType', $ticketsevent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticketsevent);
            $em->flush();

            return $this->redirectToRoute('ticketsevent_show', array('id' => $ticketsevent->getId()));
        }

        return $this->render('ticketsevent/new.html.twig', array(
            'ticketsevent' => $ticketsevent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ticketsevent entity.
     *
     * @Route("/{id}", name="ticketsevent_show")
     * @Method("GET")
     */
    public function showAction(Ticketsevent $ticketsevent)
    {
        $deleteForm = $this->createDeleteForm($ticketsevent);

        return $this->render('ticketsevent/show.html.twig', array(
            'ticketsevent' => $ticketsevent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ticketsevent entity.
     *
     * @Route("/{id}/edit", name="ticketsevent_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ticketsevent $ticketsevent)
    {
        $deleteForm = $this->createDeleteForm($ticketsevent);
        $editForm = $this->createForm('BaseBundle\Form\TicketseventType', $ticketsevent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticketsevent_edit', array('id' => $ticketsevent->getId()));
        }

        return $this->render('ticketsevent/edit.html.twig', array(
            'ticketsevent' => $ticketsevent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ticketsevent entity.
     *
     * @Route("/{id}", name="ticketsevent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ticketsevent $ticketsevent)
    {
        $form = $this->createDeleteForm($ticketsevent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticketsevent);
            $em->flush();
        }

        return $this->redirectToRoute('ticketsevent_index');
    }

    /**
     * Creates a form to delete a ticketsevent entity.
     *
     * @param Ticketsevent $ticketsevent The ticketsevent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ticketsevent $ticketsevent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ticketsevent_delete', array('id' => $ticketsevent->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
