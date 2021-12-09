<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\Ticketstheatre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ticketstheatre controller.
 *
 * @Route("ticketstheatre")
 */
class TicketstheatreController extends Controller
{
    /**
     * Lists all ticketstheatre entities.
     *
     * @Route("/", name="ticketstheatre_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ticketstheatres = $em->getRepository('BaseBundle:Ticketstheatre')->findAll();

        return $this->render('ticketstheatre/index.html.twig', array(
            'ticketstheatres' => $ticketstheatres,
        ));
    }

    /**
     * Creates a new ticketstheatre entity.
     *
     * @Route("/new", name="ticketstheatre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ticketstheatre = new Ticketstheatre();
        $form = $this->createForm('BaseBundle\Form\TicketstheatreType', $ticketstheatre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticketstheatre);
            $em->flush();

            return $this->redirectToRoute('ticketstheatre_show', array('id' => $ticketstheatre->getId()));
        }

        return $this->render('ticketstheatre/new.html.twig', array(
            'ticketstheatre' => $ticketstheatre,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ticketstheatre entity.
     *
     * @Route("/{id}", name="ticketstheatre_show")
     * @Method("GET")
     */
    public function showAction(Ticketstheatre $ticketstheatre)
    {
        $deleteForm = $this->createDeleteForm($ticketstheatre);

        return $this->render('ticketstheatre/show.html.twig', array(
            'ticketstheatre' => $ticketstheatre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ticketstheatre entity.
     *
     * @Route("/{id}/edit", name="ticketstheatre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Ticketstheatre $ticketstheatre)
    {
        $deleteForm = $this->createDeleteForm($ticketstheatre);
        $editForm = $this->createForm('BaseBundle\Form\TicketstheatreType', $ticketstheatre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticketstheatre_edit', array('id' => $ticketstheatre->getId()));
        }

        return $this->render('ticketstheatre/edit.html.twig', array(
            'ticketstheatre' => $ticketstheatre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ticketstheatre entity.
     *
     * @Route("/{id}", name="ticketstheatre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Ticketstheatre $ticketstheatre)
    {
        $form = $this->createDeleteForm($ticketstheatre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticketstheatre);
            $em->flush();
        }

        return $this->redirectToRoute('ticketstheatre_index');
    }

    /**
     * Creates a form to delete a ticketstheatre entity.
     *
     * @param Ticketstheatre $ticketstheatre The ticketstheatre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ticketstheatre $ticketstheatre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ticketstheatre_delete', array('id' => $ticketstheatre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
