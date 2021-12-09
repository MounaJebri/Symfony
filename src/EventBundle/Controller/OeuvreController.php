<?php

namespace EventBundle\Controller;
use BaseBundle\BaseBundle;
use BaseBundle\Entity\Concert;
use BaseBundle\Entity\Exposition;
use BaseBundle\Form\OeuvreType;
use BaseBundle\Entity\Oeuvre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
class OeuvreController extends Controller
{
    /**
     * @Route("/ajouterOeuvre/{id}" ,name="ajouterOeuvre" )
     */

    public function ajouterOeuvreAction(Request $request ,$id)
    {
        $oeuvre = new Oeuvre();

        $em=$this->getDoctrine()->getManager();
        $expo= $em->getRepository("BaseBundle:Exposition")->find($id);
        $oeuvre->setIdExposition($expo);

        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($oeuvre);
            $em->flush();
            $this->addFlash(
                'notice',
                'oeuvre ajouté avec succés'
            );
            return $this->redirectToRoute('detailEvent',array('id' => $id));
        }
        return $this->render('@Event/ajoutOeuvre.html.twig', array(
            "formulaire"=>$form->createView(),
            'id'=>$id
        ));
    }
    /**
     * @Route("/modifierOeuvre/{id}" ,name="modifierOeuvre" )
     */

    public function modifierOeuvreAction(Request $request ,$id)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BaseBundle:Oeuvre') ;
        $oeuvre=$repository->find($id);
        $idevent=$oeuvre->getIdExposition()->getId();

        $form = $this->createForm(OeuvreType::class, $oeuvre);
        $form->handleRequest($request);
        if($form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($oeuvre);
            $em->flush();
            $this->addFlash(
                'notice',
                'oeuvre modifié avec succés'
            );



            return $this->redirectToRoute('detailEvent',array('id' => $idevent));
        }
        return $this->render('@Event/modifierOeuvre.html.twig', array(
            "formulaire"=>$form->createView()
        ));
    }
    /**
     * @Route("/supprimerOeuvre/{id}" ,name="supprimerOeuvre" )
     */
    public function SupprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $oeuvre=$em->getRepository("BaseBundle:Oeuvre")->find($id);
        $idevent=$oeuvre->getIdExposition()->getId();
        $em->remove($oeuvre);
        $em->flush();
        return $this->redirectToRoute('detailEvent',array('id' => $idevent));
    }
}
