<?php

namespace EventBundle\Controller;

use BaseBundle\Entity\Sessionevent;
use BaseBundle\Form\SessioneventType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SessioneventController extends Controller
{
    /**
     * @Route("/ajouterSession/{id}" ,name="ajouterSession" )
     */

    public function ajouterSessionAction(Request $request ,$id)
    {
        $session = new Sessionevent();

        $em=$this->getDoctrine()->getManager();
        $expo= $em->getRepository("BaseBundle:Event")->find($id);
        var_dump($expo->getId());
        $session->setIdEvent($expo);
        $salle= $em->getRepository("BaseBundle:Salles")->find(82);
        $session->setIdSalle($salle);
        $form = $this->createForm(SessioneventType::class, $session);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($session);
            $em->flush();
            $this->addFlash(
                'notice',
                'session ajouté avec succés'
            );
            return $this->redirectToRoute('detailEvent',array('id' => $id));
        }
        return $this->render('@Event/ajoutSession.html.twig', array(
            "formulaire"=>$form->createView(),
            'id'=>$id
        ));
    }
    /**
     * @Route("/supprimerSession/{id}" ,name="supprimerSession" )
     */
    public function SupprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Session=$em->getRepository("BaseBundle:Sessionevent")->find($id);
        $idevent=$Session->getIdEvent()->getId();
        $em->remove($Session);
        $em->flush();
        return $this->redirectToRoute('detailEvent',array('id' => $idevent));
    }
}
