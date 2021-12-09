<?php

namespace BaseBundle\Controller;

use BaseBundle\Entity\Rate;
use BaseBundle\Entity\Films;
use BaseBundle\Service\RateService;
use Doctrine\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use BaseBundle\Form\RateType;


/**
 * Rate controller.
 * @Route("rate")
 */
class RateController extends Controller
{
    /**
     * Lists all rate entities.
     */
    public function viewsAction(Films $film)
    {
        $rateService = $this->container->get('RateService');
        $rates = $rateService->getReviewsByProduct($film);

        if (!empty($rates) && count($rates) > 1) {
            $ratings = [];
            $avarageRaging = 1;

            foreach ($rates as $rates) {
                array_push($ratings, $rates->getRatee());
            }

            $ratings = array_filter($ratings);
            $avarageRaging = array_sum($ratings)/count($ratings);
        } elseif (!empty($rates) && count($rates) == 1) {
            $avarageRaging = $rates[0]->getRatee();
        } else {
            $avarageRaging = null;
        }

        return $this->render('rate/views.html.twig', array(
            'rates' => $rates,
            'avarageRaging' => $avarageRaging
        ));
    }



    public function addAction(Films $film, Request $request){
        $rate = new Rate();

        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);
        if($form->isValid()){
            $rate->setIdfilm($film);

            $rateService = $this->container->get('RateService');
            $rateService ->save($rate);
            return $this->redirect($this->generateUrl('films_showw', array(
                'id' => $film->getId()
            )));
        }
        return $this->render('rate/add.html.twig', array(
            'form'      => $form->createView(),
            'film'   => $film
        ));
    }
}
