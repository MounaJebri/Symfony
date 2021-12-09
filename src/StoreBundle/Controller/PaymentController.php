<?php

namespace StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PaymentController extends Controller
{
    /**
     * @Route("/charge", name="charge")
     */
    public function chargeAction()
    {
        $stripeClient = $this->get('flosch.stripe.client');
        $chargeAmount=1000;
        $token = $_POST['stripeToken'];
        $stripeClient->createCharge($chargeAmount, "USD", $token, null, 0, "Enjoy your item!");
        return $this->redirectToRoute('store_default_panier');
    }

}
