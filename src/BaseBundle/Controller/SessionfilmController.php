<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\notification;
use BaseBundle\Entity\Sessionfilm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Sessionfilm controller.
 *
 */
class SessionfilmController extends Controller
{
    /**
     * Lists all sessionfilm entities.
     *@Route("/Sessionfilm/" , name="index_Sessionfilm_route")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sessionfilms = $em->getRepository('BaseBundle:Sessionfilm')->findAllOrderedByDate();

        return $this->render('sessionfilm/index.html.twig', array(
            'sessionfilms' => $sessionfilms,
        ));
    }

    /**
     * Lists all sessionfilm entities.
     *@Route("/Sessionfilm/x" , name="indexx_Sessionfilm_route")
     */
    public function indexxAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sessionfilms = $em->getRepository('BaseBundle:Sessionfilm')->findAllOrderedByDate();

        return $this->render('sessionfilm/indexx.html.twig', array(
            'sessionfilms' => $sessionfilms,
        ));
    }

    /**
     * Lists all sessionfilm entities.
     *@Route("/Sessionfilm/notif" , name="notif_Sessionfilm_route")
     */
    public function notifAction()
    {
        return $this->render('sessionfilm/notification.html.twig');
    }

    /**
     * Creates a new sessionfilm entity.
     *@Route("/Sessionfilm/new" , name="new_Sessionfilm_route")
     */
    public function newAction(Request $request)
    {
        $sessionfilm = new Sessionfilm();
        $form = $this->createForm('BaseBundle\Form\SessionfilmType', $sessionfilm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sessionfilm);
            $em->flush();

            $notification =new notification();
            $notification
                ->setTitle($sessionfilm ->getDate())
                ->setDescription( $sessionfilm ->getIdfilm())
                ->setRoute('show_Sessionfilm_route')
                ->setParameters(array('id'=> $sessionfilm ->getIdsession()));
            $em->persist($notification);
            $em->flush();
            $pusher = $this-> get('mrad.pusher.notificaitons');
            $pusher -> trigger($notification);


            return $this->redirectToRoute('sessionfilm_show',
                array('idsession' => $sessionfilm->getIdsession()));
        }

        return $this->render('sessionfilm/new.html.twig', array(
            'sessionfilm' => $sessionfilm,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sessionfilm entity.
     *@Route("/Sessionfilm/{id}/show" , name="show_Sessionfilm_route")
     */
    public function showAction(Sessionfilm $sessionfilm)
    {
        $deleteForm = $this->createDeleteForm($sessionfilm);

        return $this->render('sessionfilm/show.html.twig', array(
            'sessionfilm' => $sessionfilm,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sessionfilm entity.
     *
     */
    public function editAction(Request $request, Sessionfilm $sessionfilm)
    {
        $deleteForm = $this->createDeleteForm($sessionfilm);
        $editForm = $this->createForm('BaseBundle\Form\SessionfilmType', $sessionfilm);
        $editForm->handleRequest($request);



        if ($editForm->isSubmitted() && $editForm->isValid()) {
             $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('sessionfilm_edit', array('idsession' => $sessionfilm->getIdsession()));
        }

        return $this->render('sessionfilm/edit.html.twig', array(
            'sessionfilm' => $sessionfilm,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sessionfilm entity.
     *
     */
    public function deleteAction(Request $request, Sessionfilm $sessionfilm)
    {
        $form = $this->createDeleteForm($sessionfilm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sessionfilm);
            $em->flush();
        }

        return $this->redirectToRoute('sessionfilm_index');
    }

    /**
     * Creates a form to delete a sessionfilm entity.
     *
     * @param Sessionfilm $sessionfilm The sessionfilm entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sessionfilm $sessionfilm)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sessionfilm_delete', array('idsession' => $sessionfilm->getIdsession())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
