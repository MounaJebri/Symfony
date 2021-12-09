<?php

namespace StoreBundle\Controller;

use BaseBundle\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CartController
 * @package StoreBundle\Controller
 * @Route("/cart")
 */
class CartController extends Controller
{
    //------User-----//

    /**
     * @Route("/add/{id}", name="store_cart_add")
     * @Route("/add/{id}/{w}")
     */
    public function addAction($id, $w = null)
    {

        //$user = $this->get('security.token_storage')->getToken()->getUser();
        //getting the user
        $user = $this->getUser();
        //getting the product
        $repo = $this->getDoctrine()->getRepository('BaseBundle:Product');
        $prod = $repo->find($id);
        //getting the item if it exists in the cart
        $item = $this->getDoctrine()->getRepository('BaseBundle:Cart')->findOneBy(array('idP' => $prod->getId(),'idU' => $user));
        //reduce it by making method in entity
        //it will add a new item if it doesn't exits otherwise it will update the quantity
        if($item == null){
        $item = new Cart();
        if(!$w){
            $qte = 1;
        }else{
            $qte = $w;
        }
        //Populating the new item
        $item->setIdP($prod);
        $item->setIdU($user);
        $item->setName($prod->getName());
        $item->setPrice($prod->getPrice());
        $item->setQuantity($qte);
        $item->setTotal($prod->getPrice()*$qte);
        }else{
            //updating the existing item
            if(!$w){
                $qte = 1;
            }else{
                $qte = $w;
            }
            $item->setQuantity($item->getQuantity()+$qte);
            $item->setTotal($item->getPrice()*($item->getQuantity()));
        }
        //fetching it to the table
        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        //on pay method just to test here before bundle integration
        //$prod->setQuantity($prod->getQuantity() - $qte);
        $em->flush();
        //Show result
        return new Response('Item added successfully, Enjoy!');
    }

    /**
     * @Route("/delete/{id}",name="store-cart-minus")
     */
    public function deleteAction($id){
        $cart = $this->getDoctrine()->getRepository('BaseBundle:Cart')->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($cart);
        $entityManager->flush();

        return new Response('Item deleted successfully');
    }

    /**
     * @Route("/Alter/{id}/{qty}", name="add_plus")
     * @param Cart $cart
     * @param int $qty
     * @return JsonResponse
     */
    public function addQtyAction(Cart $item, int $qty){

        $cart = $this->getDoctrine()
                     ->getRepository('BaseBundle:Cart')
                     ->findOneBy(array('id' => $item));
        $manager = $this->getDoctrine()->getManager();
            if($cart->getQuantity() < $qty) {
                $cart->setQuantity($qty);
                $cart->setTotal($cart->getPrice()*$qty);
                $manager->persist($cart);
                $manager->flush();

                return $this->json(['code' => 200,
                    'message' => 'Quantity increased',
                    'likes' => $cart->getTotal()], 200);
            }
            $cart->setQuantity($qty);
            $cart->setTotal($cart->getPrice()*$qty);
            $manager->persist($cart);
            $manager->flush();
            return $this->json(['code' => 200,
                'message' => 'Quantity reduced',
                'new qty' => $cart->getQuantity()],200);
    }
}
