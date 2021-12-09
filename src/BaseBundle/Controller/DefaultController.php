<?php

namespace BaseBundle\Controller;

use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Query\AST\OrderByClause;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('@Base/Default/index.html.twig');
    }

    /**
     * @Route("/test")
     */
    public function TestAction()
    {
        return $this->render('@Base/sizebi.html.twig');
    }

    /**
     * @Route("/events")
     */
    public function eventsAction()
    {
        return $this->render('@Base/events.html.twig');
    }

    /**
     * @Route("/movies")
     */
    public function moviesAction()
    {
        return $this->render('@Base/movies.html.twig');
    }

    /**
     * @Route("/theatres")
     */
    public function theatresAction()
    {
        return $this->render('@Base/theatres.html.twig');
    }

    /**
     * @Route("/acteurs")
     */
    public function acteursAction()
    {
        return $this->render('@Base/acteurs.html.twig');
    }

    /**
     * @Route("/musee")
     */
    public function museeAction()
    {
        return $this->render('@Base/musee.html.twig');
    }

    /**
     * @Route("/guides")
     */
    public function guidesAction()
    {
        return $this->render('@Base/guides.html.twig');
    }

    /**
     * @Route("/salledetheatre")
     */
    public function salledetheatreAction()
    {
        return $this->render('@Base/salledetheatre.html.twig');
    }
    /**
     * @Route("/salledecinema")
     */
    public function salledecinemaAction()
    {
        return $this->render('@Base/sallecinema.html.twig');
    }
    /**
     * @Route("/autresespace")
     */
    public function autresespaceAction()
    {
        return $this->render('@Base/autresespace.html.twig');
    }
    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return $this->render('@Base/adminindex.html.twig');
    }
    /**
     *
     *
     * @Route("/sallesstats", name="salles_stats")
     *
     */
    public function sallesstats ()
    {
        $em = $this->getDoctrine()->getManager() ;
        $salles = $em->getRepository('BaseBundle:Salles')->findAll();
        $tab = array('salle' ,'count') ;
        $i = 0 ;
        foreach ($salles as $salle)
        {
            $n1 = $em->getRepository('BaseBundle:Sessionevent')->findBy(array("idSalle" => $salle));
            $n2 = $em->getRepository('BaseBundle:Sessionfilm')->findBy(array("idsalle" => $salle));
            $n3 = $em->getRepository('BaseBundle:Sessiontheatre')->findBy(array("idSalle" => $salle));
            $tab[$salle->getId()]=(count($n3)+count($n2)+count($n1))    ;
        }

        return $this->render('@Base/sallestats.html.twig',array(
            'salles' => $salles, 'count'=> $tab ));
    }
    /**
     *
     *
     * @Route("/ticketsstats", name="tickets_stats")
     *
     */
    public function ticketsstats ()
    {
        $em = $this->getDoctrine()->getManager() ;

            $n1 = $em->getRepository('BaseBundle:Ticketsevent')->findAll();
            $n2 = $em->getRepository('BaseBundle:Ticketsfilm')->findAll();
            $n3 = $em->getRepository('BaseBundle:Ticketstheatre')->findAll();


        return $this->render('@Base/ticketsstats.html.twig',array(
            'events' => count($n1), 'films'=> count($n2), 'theatres'=> count($n3) ));
    }
    /**
     *
     *
     * @Route("/ticketstimestats", name="tickets_time_stats")
     *
     */
    public function ticketstimestats ()
    {
        $em = $this->getDoctrine()->getManager() ;

        $n1 = $em->getRepository('BaseBundle:Sessionevent')->findBy(array(),array('dateDeb'=>'asc'));
        $n2 = $em->getRepository('BaseBundle:Sessionfilm')->findBy(array(),array('heure'=>'asc'));
        $n3 = $em->getRepository('BaseBundle:Sessiontheatre')->findBy(array(),array('dateDebut'=>'asc')) ;


        return $this->render('@Base/ticketstimestats.html.twig',array(
            'events' => $n1, 'eventcount'=> count($n1), 'films'=> $n2 , 'filmcount'=>count($n2) , 'theatres'=>$n3 , 'theatrescount'=> count($n3)) );
    }
    /**
     *
     *
     * @Route("/check", name="check")
     *
     */
    public function checkcalendar ($id,$datedeb,$datefin)
    {
        $em = $this->getDoctrine()->getManager() ;

        $n1 = $this
            ->getDoctrine()
            ->getManager()
            ->createQuery( "SELECT p FROM BaseBundle:Sessionevent 
                            where p.idSalle = :id
                            and 
                            (((:datededebut between (date_deb and date_fin))  or (:datedefin between (date_deb and date_fin))) 
                                                  or 
                                ( (date_deb between (:datededebut and :datedefin))  and  (date_fin between (:datededebut and :datedefin)))  )                                                    
                            
                            ")
            ->setParameter('id',$id , 'datededebut',$datedeb,'datedefin',$datefin)
            ->getResult() ;



        return $this->render('@Base/ticketstimestats.html.twig',array(
            'check' => count($n1)  ));
    }

    /**
     *
     *
     * @Route("/fullcc", name="full")
     *
     */
    public function calendar ()
    {

        return $this->render('@Base/fullcalendar.html.twig');
    }

}

