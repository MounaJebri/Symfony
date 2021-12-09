<?php

namespace EventBundle\Controller;

use BaseBundle\Entity\Event;
use BaseBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
{
    /*
    /**
     * @Route("/AjoutComm/{id}", name="AjoutComm")
     */
    /*
    public function AjoutComm(Request $request , $id)
    {
        $comment = new Commentaire( );


        if($request->isMethod('POST'))
        {
            $user=$this->getUser();
            $em=$this->getDoctrine()->getManager();
            $event=$em->getRepository("BaseBundle:Event")->find($id);
            $comment->setIdEvent($event);
            $comment->setContenu($request->get('contenu'));
            $comment->setOwner($user->getUsernameCanonical());
            $comment->setStatus(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

        }
        return ($this->render('@Event/detailEvent.html.twig'));
    }
    */
    /**
     * @Route("/SupprimerComm/{id}", name="SupprimerComm")
     */
    public function SupprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comm=$em->getRepository("BaseBundle:Commentaire")->find($id);
        $idevent=$comm->getIdEvent()->getId();
        $em->remove($comm);
        $em->flush();
        return $this->redirectToRoute('detailEvent',array('id' => $idevent));
    }
    /**
     * @Route("/AfficherCommAdmin", name="AfficherCommAdmin")
     */
    public function listerCommAdminAction()
    {

        $repository=$this
            ->getDoctrine()
            ->getManager()
            ->getRepository("BaseBundle:Commentaire");
        $listeComm=$repository->findAll();




        return $this->render('@Event/afficherCommAdmin.html.twig',array('listecom'=>$listeComm));
    }
    /**
     * @Route("/modifierStatusComm/{id}", name="modifierStatusComm")
     */
    public function modifierStatusCommAction(Request $request,$id)
    {
        $em = $this
            ->getDoctrine()
            ->getManager()
            ;
        $comm=$em->getRepository('BaseBundle:Commentaire') ->find($id);
        if (($comm->getStatus()=="signalé")&& ((($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')))))
        {
            $comm->setStatus("non signalé");
        }
        else
        {
            $comm->setStatus("signalé");
        }
        $idevent=$comm->getIdEvent()->getId();
        $em->persist($comm);
        $em->flush();
        if ((($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))))
             return $this->redirectToRoute('AfficherCommAdmin');
        else if ((($this->get('security.authorization_checker')->isGranted('ROLE_USER'))))
            return $this->redirectToRoute('detailEvent',array('id' => $idevent));
    }
    /**
     * @Route("/StatsCommEvent", name="StatsCommEvent")
     */
    public function StatsCommEventAction(Request $request)
    {

        $types=array('concert', 'exposition', 'conference', 'seminaire', 'reunion');
        $myArray = array();
        foreach ($types as $type) {

            $em = $this
                ->getDoctrine()
                ->getManager();
            $count = $em->getRepository('BaseBundle:Commentaire')->NbComm($type);
            var_dump($count);
            array_push($myArray,$count);

        }
        var_dump($myArray);
        return $this->render('@Event/StatsChartAdmin.html.twig',array('myarray' => $myArray,'type' => $types));
    }



}
