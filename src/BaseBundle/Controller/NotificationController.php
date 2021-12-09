<?php

namespace BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BaseBundle\Entity\notification;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends Controller
{

    public function displayAction()
    {
        $notification = $this->getDoctrine()->getManager()->getRepository('BaseBundle:Notification')->findAll();
        return $this->render('sessionfilm/notification.html.twig',array(
            'notification' => $notification
        ));
    }
}
