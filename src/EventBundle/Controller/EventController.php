<?php

namespace EventBundle\Controller;

use BaseBundle\Entity\Commentaire;
use BaseBundle\Entity\Concert;
use BaseBundle\Entity\Exposition;
use BaseBundle\Entity\Event;
use BaseBundle\Form\EventType;
use EventBundle\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class EventController extends Controller
{


    function filter($string) {
        $words = array("azerty", "qwerty");
        $new =   array("****", "*******");
        $string1 = str_ireplace($words, $new, $string);
        $left = preg_replace("/[\* ]+/", "", $string1);
        if (strlen($left) == 0) {
            $string1 = "[ Content Deleted ]";
            return $string1;
        }
        else {
            return $string1;
        }
    }
    /**
     * @Route("/events" ,name="ListerEvent" )
     */

    public function ListerEventAction()
    {
        $repository=$this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BaseBundle:Event');
        $listEvent= $repository->findAll();
        if ((($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))))
        {
            $xx = 1;
        }
        else
        {
            $xx = 0;
        }
        $em=$this
            ->getDoctrine()
            ->getManager();
        $query='select e.* FROM Event e ORDER BY (select count(*) FROM commentaire c WHERE e.id= c.id_event) DESC LIMIT 3';
        $statement = $em->getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll();



        foreach ($result as $key =>$value )
        {
            $x = array_column($result, 'titre');

            $i=0;
            foreach ($x as $key => $value)
            {$i++;


                if ($i==1)
                {
                    $e1=$value;

                }
                if ($i==2)
                {
                    $e2=$value;


                }
                if ($i==3)
                {
                    $e3=$value;

                }
            }
            break;
        }

        return $this->render('@Event/events.html.twig',array("events"=>$listEvent,
            'x'=>$xx,
            'event1'=>$e1,
            'event2'=>$e2,
            'event3'=>$e3));
    }
    /**
     * @Route("/eventsUser" ,name="eventsUser" )
     */

    public function listerEventUserAction()
    {
        $user=$this->getUser();
        $iduser=$user->getId();
        $repository=$this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BaseBundle:Event');
        $listEvent= $repository->findBy(array(
            'idUser' => $iduser
        ));


        return $this->render('@Event/afficherEventUser.html.twig',array("events"=>$listEvent));
    }
    /**
     * @Route("/detailEvent/{id}",name="detailEvent" )
     */
    public function detailEventAction(Request $request, $id )
    {
        $em=$this->getDoctrine()->getManager();
        $query='select e.* FROM Event e ORDER BY (select count(*) FROM commentaire c WHERE e.id= c.id_event) DESC LIMIT 3';
        $statement = $em->getConnection()->prepare($query);
        $statement->execute();

        $result = $statement->fetchAll();



        foreach ($result as $key =>$value )
        {
            $x = array_column($result, 'titre');

            $i=0;
            foreach ($x as $key => $value)
            {$i++;


                if ($i==1)
                {
                    $e1=$value;

                }
                if ($i==2)
                {
                    $e2=$value;


                }
                if ($i==3)
                {
                    $e3=$value;

                }
            }
            break;
        }


        $user=$this->getUser();

        $em=$this->getDoctrine()->getManager();
        $event=$em->getRepository("BaseBundle:Event")->find($id);
        $titre=$event->getTitre();
        $prix=$event->getPrix();
        $description=$event->getDescription();
        $duree=$event->getDuree();
        $etat=$event->getEtat();
        $image=$event->getImage();
        $typeEvent=$event->getTypeEvent();
        $idue=$event->getIdUser();

        $em=$this->getDoctrine()->getManager();
        $listeSession=$em->getRepository("BaseBundle:Sessionevent")->findby(
            array('idEvent' => $event->getId())
        );
        $em=$this->getDoctrine()->getManager();
        $listeComment=$em->getRepository("BaseBundle:Commentaire")->findby(
            array('idEvent' => $event->getId())
        );





        if($request->isMethod('POST'))
        {
            $comment = new Commentaire( );
            //$user=$this->getUser();
            $em=$this->getDoctrine()->getManager();
            $event=$em->getRepository("BaseBundle:Event")->find($id);
            $time = new \DateTime();
            $time->format('\O\n Y-m-d');
            $comment->setIdEvent($event);
            $comment->setDate($time);
            $filtredContent=$this->filter($request->get('contenu'));
            $comment->setContenu($filtredContent);
            $comment->setOwner($user->getUsername());
            $comment->setStatus('non signalé');
            $userimage=$user->getUsername();
            $userimage=$userimage.".png";
            $comment->setImage($userimage);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('ListerEvent');

        }








        if ((($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))))
        {
            $x = 1;
        }
        else
        {
            $x = 0;
        }
        if ($typeEvent == "concert")
        {

            $em=$this->getDoctrine()->getManager();
            $concert=$em->getRepository("BaseBundle:Concert")->find($id);
            $listeArtiste=$concert->getListeArtistes();
            $typeConcert=$concert->getTypeConcert();
            return $this->render('@Event/detailEvent.html.twig', array(
                'x'=>$x,
                'username'=>$user->getUsername(),
                'email'=>$user->getEmail(),
                'event1'=>$e1,
                'event2'=>$e2,
                'event3'=>$e3,
                'id'=>$id,
                'titre'=>$titre,
                'prix'=>$prix,
                'description'=>$description,
                'duree'=>$duree,
                'etat'=>$etat,
                'image'=>$image,
                'typeEvent'=>$typeEvent,
                'idue'=>$idue,
                'listeSessions'=>$listeSession,
                'listeArtistes'=>$listeArtiste,
                'listeComm'=>$listeComment,
                'username'=>$user->getUsername(),
                'userid'=>$user->getId(),
                'typeConcert'=>$typeConcert));
        }
        if ($typeEvent == "exposition")
        {

            $em=$this->getDoctrine()->getManager();
            $exposition=$em->getRepository("BaseBundle:Exposition")->find($id);
            $nombreRayon=$exposition->getNombreRayon();
            $em=$this->getDoctrine()->getManager();
            $Listeoeuvre=$em->getRepository("BaseBundle:Oeuvre")->findBy(
                array('idExposition' => $exposition->getId())
            );
            return $this->render('@Event/detailEvent.html.twig', array(
                'id'=>$id,
                'username'=>$user->getUsername(),
                'event1'=>$e1,
                'event2'=>$e2,
                'event3'=>$e3,
                'email'=>$user->getEmail(),
                'x'=>$x,
                'titre'=>$titre,
                'prix'=>$prix,
                'description'=>$description,
                'duree'=>$duree,
                'etat'=>$etat,
                'image'=>$image,
                'typeEvent'=>$typeEvent,
                'idue'=>$idue,
                'listeSessions'=>$listeSession,
                'nombreRayon'=>$nombreRayon,
                'listeComm'=>$listeComment,
                'Listeoeuvre'=>$Listeoeuvre));
        }



        return $this->render('@Event/detailEvent.html.twig', array(
            'id'=>$id,
            'x'=>$x,
            'event1'=>$e1,
            'event2'=>$e2,
            'event3'=>$e3,
            'username'=>$user->getUsername(),
            'email'=>$user->getEmail(),
            'titre'=>$titre,
            'prix'=>$prix,
            'description'=>$description,
            'duree'=>$duree,
            'etat'=>$etat,
            'image'=>$image,
            'typeEvent'=>$typeEvent,
            'listeSessions'=>$listeSession,
            'listeComm'=>$listeComment,
            'idue'=>$idue));

    }
    /**
     * @Route("/typeevent", name="typeevent")
     */
    public function typeEventAction(Request $request)
    {
        return $this->render('@Event/typeEvent.html.twig');
    }

    /**
     * @Route("/ajouterevent/{type}", name="ajouterevent")
     */
    public function ajouterEventAction(Request $request , $type)
    {
        $user=$this->getUser();
        if ((($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))))
        {
            $x=1;
        }
        else
        {
            $x=0;
        }
        if ($type=="concert")
        {

            $event = new Concert();
            $event->setTypeEvent("concert");
            $event->setIdUser($user);
            $event->setEtat($x);
            $form = $this->createForm(EventType::class, $event);
            if($x==0)
            {
                $form->remove('etat');
            }
        }
        else if ($type=="exposition")
        {
            $event = new Exposition();
            $event->setTypeEvent("exposition");
            $event->setIdUser($user);
            $event->setEtat($x);
            $form = $this->createForm(EventType::class, $event);
            if($x==0)
            {
                $form->remove('etat');
            }
        }
        else
        {
            $event = new Event();
            $event->setIdUser($user);
            $event->setTypeEvent($type);
            $event->setEtat($x);
            $form = $this->createForm(EventType::class, $event);
            if($x==0)
            {
                $form->remove('etat');
            }
        }
        $form->handleRequest($request);
        if($form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            $this->addFlash(
                'notice',
                'evenement ajouté avec succés'
            );
            return $this->redirectToRoute('ListerEvent');
        }
        return $this->render('@Event/ajoutEvent.html.twig', array(
            "formulaire"=>$form->createView(),
            'type'=>$type

        ));
    }


     /**
      * @Route("/modifierevent/{id}", name="modifierevent")
      */
     public function ModifierEventAction(Request $request,$id)
     {
         $repository = $this
             ->getDoctrine()
             ->getManager()
             ->getRepository('BaseBundle:Event') ;
         $event=$repository->find($id);
         $etat=$event->getEtat();
         if ($event->getTypeEvent()=="concert")
         {
             $event = new Concert();
             $repository = $this
                 ->getDoctrine()
                 ->getManager()
                 ->getRepository('BaseBundle:Concert') ;
             $event=$repository->find($id);
             $form = $this->createForm(EventType::class, $event);
         }
         else if ($event->getTypeEvent()=="exposition")
         {
             $event = new Exposition();
             $repository = $this
                 ->getDoctrine()
                 ->getManager()
                 ->getRepository('BaseBundle:Exposition') ;
             $event=$repository->find($id);
             $form = $this->createForm(EventType::class, $event);
         }
         $form   = $this->get('form.factory')->create(EventType::class,$event );
         if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
             $em = $this->getDoctrine()->getManager();
             $em->persist($event);
             $em->flush();
             if (!$etat==$event->getEtat())
             {
                 //Ici le mail de validation
                 $message = \Swift_Message::newInstance()
                     ->setSubject('Etat de votre événement ')
                     ->setFrom(array('tclsmailsender@gmail.com' => "TCLS"))
                     ->setTo($event->getIdUser()->getEmailCanonical())
                     ->setCharset('utf-8')
                     ->setContentType('text/html')
                     ->setBody($this->renderView('@Event/mailBody.html.twig',array('user' => $event->getIdUser(),
                         'etat'=> $event->getEtat(),
                         'titre'=> $event->getTitre())));

                 $this->get('mailer')->send($message);

             }

             $request->getSession()->getFlashBag()->add('notice', 'Event bien enregistrée.');
             return $this->redirectToRoute('ListerEvent');


         }
         return $this->render('@Event/modifierEvent.html.twig', array(
             'formulaire' => $form->createView(),
             'type'=>$event->getTypeEvent()
         ));
     }
    /**
     * @Route("/supprimerevent/{id}", name="supprimerevent")
     */
    public function SupprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event=$em->getRepository("BaseBundle:Event")->find($id);
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('ListerEvent');
    }






}
