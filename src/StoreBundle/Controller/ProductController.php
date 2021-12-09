<?php

namespace StoreBundle\Controller;

use BaseBundle\Entity\ProdFav;
use BaseBundle\Entity\Product;
use BaseBundle\Repository\ProdFavRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BaseBundle\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * Class ProductController
 * @package StoreBundle\Controller
 * @Route("/store")
 */
class ProductController extends Controller
{
    //-------USER-------//

    /**
     * @Route("/tri", name="tri")
     *
     */
    public function lowAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $manager->getRepository("BaseBundle:Product")->findBy(
      [],
        ['price' => 'ASC'],
            $limit = $request->get('n')
    );
        $normalizer = new ObjectNormalizer();
        $serializer=new Serializer(array(new DateTimeNormalizer(),$normalizer));
        $data=$serializer->normalize($product, null, array('attributes' => array('id','name','price','imageName','quantity')));
        return new JsonResponse($data);
    }
    /**
     * @Route("/high", name="high")
     *
     */
    public function highAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $manager->getRepository("BaseBundle:Product")->findBy(
            [],
            ['price' => 'DESC'],
            $limit = $request->get('n')
        );
        $normalizer = new ObjectNormalizer();
        $serializer=new Serializer(array(new DateTimeNormalizer(),$normalizer));
        $data=$serializer->normalize($product, null, array('attributes' => array('id','name','price','imageName','quantity')));
        return new JsonResponse($data);
    }

    /**
     * @Route("/nameprod", name="name_prod")
     *
     */
    public function nameAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $manager->getRepository("BaseBundle:Product")->findBy(
            [],
            ['name' => 'ASC'],
            $limit = $request->get('n')
        );
        $normalizer = new ObjectNormalizer();
        $serializer=new Serializer(array(new DateTimeNormalizer(),$normalizer));
        $data=$serializer->normalize($product, null, array('attributes' => array('id','name','price','imageName','quantity')));
        return new JsonResponse($data);
    }

    /**
     * @Route("/products", name="store_user")
     *
     */
    public function listAction()
    {
        $doctrine = $this->getDoctrine();

        $repository = $doctrine->getRepository('BaseBundle:Product');
        $repo = $doctrine->getRepository('BaseBundle:ProdFav');
        $likes = $repo->findBy(array('idU' => $this->getUser()));
        $list = $repository->findAll();
        $products = $repository->findby([],
            [],
                $limit  = 6,
                $offset = null);

        return $this->render('@Store/Product/Client/list.html.twig', array(
            "products" => $products, 'counted' => count($list) , 'likes' => count($likes)
        ));
    }

    /**
     * @Route("/count", name="count")
     *
     */
    public function CountAction(Request $request)
    {

        $doctrine = $this->getDoctrine();

        $repository = $doctrine->getRepository('BaseBundle:Product');

        $product = $repository->findAll();
        return new JsonResponse(count($product));
    }

    /**
     * @Route("/loadmore", name="loadmore")
     *
     */
    public function loadmoreAction(Request $request)
    {

        $doctrine = $this->getDoctrine();

        $repository = $doctrine->getRepository('BaseBundle:Product');

        $product = $repository->findby([],
            [],
            $limit  = 6,
            $offset = $request->get("n"));
        $normalizer = new ObjectNormalizer();
        $serializer=new Serializer(array(new DateTimeNormalizer(),$normalizer));
        $data=$serializer->normalize($product, null, array('attributes' => array('id','name','price','imageName','quantity')));
        return new JsonResponse($data);
    }

    //-------Admin-------//

    /**
     * @Route("/insert")
     * @Route("/edit/{id}" , name="store_product_edit")
     */
    public function insertAction(Request $request, Product $task = null)
    {
        if ($this->isGranted("ROLE_ADMIN")) {
            if (!$task) {
                $task = new Product();
            }
            $form = $this->createForm(Form\ProductType::Class, $task);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($task);
                $entityManager->flush();

                return $this->redirectToRoute('store_admin');
            }

            return $this->render('@Store/Product/Admin/insert.html.twig', [
                'formProduct' => $form->createView(), 'editMode' => $task->getId() !== null,]);
        }
        return new Response("You are not an authorized admin!");
    }

    /**
     * @Route("/admin/list", name="store_admin")
     */
    public function tableAction()
    {
        if ($this->isGranted("ROLE_ADMIN")) {

            $doctrine = $this->getDoctrine();
            $repo = $doctrine->getRepository('BaseBundle:Product');
            $prods = $repo->findAll();

            return $this->render('@Store/Product/Admin/list.html.twig', array("products" => $prods));
        }
        return new Response("You are not an authorized admin!");
    }

    /**
     * @Route("/delete/{id}", name="store_product_delete")
     */
    public function deleteAction(Product $product)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();
        $doctrine = $this->getDoctrine();
        $repo = $doctrine->getRepository('BaseBundle:Product');
        $prods = $repo->findAll();
        return $this->render('@Store/Product/Admin/list.html.twig', array("products" => $prods));
    }
    //----------Favorites--------//

    /**
     * used to favor or not a product!
     *
     * @Route("/product/favor/{id}", name="product_favor")
     * @param Product $product
     * @return JsonResponse
     */
    public function favorite(Product $product){
        $user = $this->getUser();
        $favRepo = $this->getDoctrine()->getRepository('BaseBundle:ProdFav');
        $manager = $this->getDoctrine()->getManager();
        if(!$user) return $this->json(['code' => 'You have to log in!'],403);

        if($product->isLikedByUser($user))
        {
            $favor = $favRepo->findOneBy([
                'idU' => $user,
                'idP' => $product
            ]);

            $manager->remove($favor);
            $manager->flush();

            return $this->json(['code' => 200,
                                'message' => 'Product removed from favorites',
                                'likes' => $favRepo->count(['idP' => $product])],200);
        }

        $favor = new ProdFav();
        $favor->setIdP($product);
        $favor->setIdU($user);

        $manager->persist($favor);
        $manager->flush();
        return $this->json(['code' => 200 ,
            'message' => 'You favored a product',
            'likes' => $favRepo->count(['idP' => $product])],200);

    }

}
