<?php

namespace MuseeBundle\Controller;
use MuseeBundle\Entity\Guide;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;


/**
 * Guide controller.
 *
 */
class GuideController extends Controller
{
    /**
     * Lists all guide entities.
     *
     */
    public function indexAction(Request $request)
    {

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT g FROM MuseeBundle:Guide g";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );

        // parameters to template
        return $this->render('guide/index.html.twig', array('pagination' => $pagination));
    }

    /**
     * Creates a new guide entity.
     *
     */
    public function newAction(Request $request)
    {
        $guide = new Guide();
        $form = $this->createForm('MuseeBundle\Form\GuideType', $guide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($guide);
            $em->flush();

            return $this->redirectToRoute('guide_show', array('id' => $guide->getId()));
        }

        return $this->render('guide/new.html.twig', array(
            'guide' => $guide,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a guide entity.
     *
     */
    public function showAction(Guide $guide)
    {
        $deleteForm = $this->createDeleteForm($guide);

        return $this->render('guide/show.html.twig', array(
            'guide' => $guide,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing guide entity.
     *
     */
    public function editAction(Request $request, Guide $guide)
    {
        $deleteForm = $this->createDeleteForm($guide);
        $editForm = $this->createForm('MuseeBundle\Form\GuideType', $guide);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('guide_edit', array('id' => $guide->getId()));
        }

        return $this->render('guide/edit.html.twig', array(
            'guide' => $guide,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a guide entity.
     *
     */
    public function deleteAction(Request $request, Guide $guide)
    {
        $form = $this->createDeleteForm($guide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($guide);
            $em->flush();
        }

        return $this->redirectToRoute('guide_index');
    }


    /**
     * Creates a form to delete a guide entity.
     *
     * @param Guide $guide The guide entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Guide $guide)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('guide_delete', array('id' => $guide->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    public function rechercheAction()

    {



        $connect = mysqli_connect("localhost","root","","tcls");
$output = '';
if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($connect, $_POST["query"]);
	$query = "
	SELECT * FROM guide
	WHERE nom LIKE '%".$search."%'
	OR prenom LIKE '%".$search."%' 
	OR description LIKE '%".$search."%' 
	";
}
else
{
	$query = "
	SELECT * FROM guide ORDER BY id";
}
$result = mysqli_query($connect, $query);
if(mysqli_num_rows($result) > 0)
{
	$output .= '<div class="table-responsive">
					<table class="table table bordered">
						<tr>
							<th>nom</th>
							<th>prenom</th>
							<th>date</th>
							<th>h_debut</th>
							<th>description</th>
						</tr>';
	while($row = mysqli_fetch_array($result))
	{
		$output .= '
			<tr>
				<td>'.$row["nom"].'</td>
				<td>'.$row["prenom"].'</td>
				<td>'.$row["date"].'</td>
				<td>'.$row["h_debut"].'</td>
				<td>'.$row["description"].'</td>
			</tr>
		';
	}
	echo $output;
}
else
{
	echo 'Data Not Found';
}

        return $this->render('guide/recherche.html.twig');
    }

    public function todayAction()
    {
        $em = $this->getDoctrine()->getManager();
        $guides=$em->getRepository('MuseeBundle:Guide')->findAll();
        $today=Date("Y-m-d");

            if ($guide->getDate() == $today) {
                return $this->render(
                    'guide/today.html.twig',
                    array('guides' => $guide)
                );
            }


    }
    public function exportAction(){
        $em = $this->getDoctrine()->getManager();
        $guides=$em->getRepository('MuseeBundle:Guide')->findAll();
        $writer = $this->container->get('egyg33k.csv.writer');
        $csv = $writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['nom','description']);
        foreach ($guides as $guide){
            $csv->insertOne([$guide->getNom(),$guide->getDescription()
            ]);
        }
        $csv->output('guides.csv');
        die('export');
    }
    public function allAction(){
        $visites=$this->getDoctrine()->getManager()->getRepository('MuseeBundle:Guide')->findAll();
        $serializer = new Serializer([new DateTimeNormalizer('d-M-Y'),new ObjectNormalizer()]);
        $formatted=$serializer->normalize($visites);
        return new JsonResponse($formatted);
    }



}
