<?php

namespace StoreBundle\Controller;

use BaseBundle\Entity\Cart;
use BaseBundle\Form\CartType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * @Route("/shop")
     */
    public function shopAction()
    {
        return $this->redirectToRoute('store_user');
    }

    /**
     * @Route("/panier")
     */
    public function panierAction()
    {
        $repo = $this->getDoctrine()->getRepository('BaseBundle:Cart');
        $items = $repo->findBy(array('idU' => $this->getUser()));
        $total= 0;
        for($i = 0;$i<count($items);$i++)
        {
            $total+= $items[$i]->getTotal();
        }
        return $this->render('@Store/panier.html.twig', array('Items' => $items,'total' => $total));
    }

    /**
     * @Route("/product/{id}", name="store_one")
     */
    public function singleAction($id,Request $request)
    {
        $task = new Cart();

        $form = $this->createForm(CartType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $task->setIdU($this->getUser());
            $repo = $this->getDoctrine()->getRepository('BaseBundle:Product');
            $prod = $repo->find($id);
            $verif = $this->getDoctrine()->getRepository('BaseBundle:Cart')->findOneBy(array('idP' => $prod->getId(),'idU' => $this->getUser()));


            return $this->redirectToRoute('store_admin');
        }

        $repo = $this->getDoctrine()->getRepository('BaseBundle:Product');
        $rep = $this->getDoctrine()->getRepository('BaseBundle:Cart');
        $cart = [];
        if($this->getUser() !== null) {
            $cart = $rep->findBy(array('idU' => $this->getUser()->getId()));
        }
        $prod = $repo->findOneBy(array('id' => $id));

        return $this->render('@Store/product.html.twig',array('product' => $prod,'qty' => count($cart),
            'form' => $form->createView()));
    }
}
