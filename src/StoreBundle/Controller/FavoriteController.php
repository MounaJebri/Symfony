<?php

namespace StoreBundle\Controller;

use BaseBundle\Entity\ProdFav;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class FavoriteController extends Controller
{

    public function showAction()
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('BaseBundle:Product');
        $list = $repository->findAll();
        /*$products = $repository->findby([],
            [],
            $limit  = 6,
            $offset = null);*/

        return $this->render('@Store/Favorite/show.html.twig', array(
            "products" => $list, 'counted' => count($list)
        ));
    }
    /**
     * @Route("/user/favor", name="user_favor")
     */
    public function listAction()
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('BaseBundle:ProdFav');
        $list = $repository->findby(['idU' => $this->getUser()]);

        return $this->render('@Store/Favorite/show.html.twig', array(
            "products" => $list, 'counted' => count($list)
        ));
    }

}
