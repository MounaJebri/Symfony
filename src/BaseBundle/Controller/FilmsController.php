<?php

namespace BaseBundle\Controller;
use BaseBundle\Entity\Films;
use BaseBundle\Entity\Sessionfilm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BaseBundle\Repository\FilmsRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Mapping\Entity;

/**
 * Film controller.
 *
 */
class FilmsController extends Controller
{
    /**
     * Lists all film entities.
     *@Route("/Films/" , name="index_Films_route")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $films = $em->getRepository('BaseBundle:Films')->findAllOrderedByName();
        return $this->render('films/index.html.twig', array(
            'films' => $films,
        ));
    }

    /**
     * Lists all film entities.
     *@Route("/Films/x" , name="indexx_Films_route")
     */
    public function indexxAction()
    {
        $em = $this->getDoctrine()->getManager();
        $films = $em->getRepository('BaseBundle:Films')->findAll();



        return $this->render('films/indexx.html.twig', array(
            'films' => $films
        ));
    }
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $films =  $em->getRepository('BaseBundle:Films')->findEntitiesByString($requestString);
        if(!$films) {
            $result['films']['error'] = "Film Not found :( ";
        } else {
            $result['films'] = $this->getRealEntities($films);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($films){
        foreach ($films as $films){
            $realEntities[$films->getId()] = [$films->getimage(),$films->getTitre()];

        }
        return $realEntities;
    }


    /**
     * Finds and displays a film entity.
     *@Route("/Films/{id}/showw" , name="showw_Films_route")
     */
    public function showwAction(Films $film)
    {
        $deleteForm = $this->createDeleteForm($film);
        $em = $this->getDoctrine()->getManager();
        $sessionfilm = $em->getRepository('BaseBundle:Sessionfilm')->findby(
            array('idfilm'=>$film -> getId()  ));

        return $this->render('films/moviesingle.html.twig', array(
            'film' => $film,
            'sessionfilm' => $sessionfilm,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a new film entity.
     *@Route("/Films/new" , name="new_Films_route")
     */
    public function newAction(Request $request)
    {
        $film = new Films();
        $form = $this->createForm('BaseBundle\Form\FilmsType', $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $film->uploadProfilePicture();
            $em->persist($film);
            $em->flush();

            return $this->redirectToRoute('films_show', array('id' => $film->getId()));
        }

        return $this->render('films/new.html.twig', array(
            'film' => $film,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a film entity.
     *@Route("/Films/{id}/show" , name="show_Films_route")
     */
    public function showAction(Films $film)
    {
        $deleteForm = $this->createDeleteForm($film);

        return $this->render('films/show.html.twig', array(
            'film' => $film,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing film entity.
     *@Route("/Films/{id}/edit" , name="edit_Films_route")
     */
    public function editAction(Request $request, Films $film)
    {
        $deleteForm = $this->createDeleteForm($film);
        $editForm = $this->createForm('BaseBundle\Form\FilmsType', $film);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('films_edit', array('id' => $film->getId()));
        }

        return $this->render('films/edit.html.twig', array(
            'film' => $film,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a film entity.
     *
     */
    public function deleteAction(Request $request, Films $film)
    {
        $form = $this->createDeleteForm($film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($film);
            $em->flush();
        }

        return $this->redirectToRoute('films_index');
    }




    /**
     * Creates a form to delete a film entity.
     *
     * @param Films $film The film entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Films $film)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('films_delete', array('id' => $film->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
