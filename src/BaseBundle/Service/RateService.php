<?php
/**
 * Created by PhpStorm.
 * User: mouna
 * Date: 14/04/2019
 * Time: 11:03
 */

namespace BaseBundle\Service;

use Doctrine\ORM\EntityManager;
use BaseBundle\Entity\Rate;
use BaseBundle\Entity\Films;

class RateService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $RateRepository;

    /**
     * @param EntityManager $entityManager
     */
    function __construct(EntityManager $entityManager){
        $this->em = $entityManager;
        $this->RateRepository = $this->em->getRepository('BaseBundle:Rate');
    }

    /**
     * Return an Review by id
     * @param $id integer
     * @return Rate|null
     */
    public function getReviewById($id){
        return $this->RateRepository->find($id);
    }

    /**
     * Returns a list of approved reviews by an product sorted by DESC
     */
    public function getReviewsByProduct(Films $film){
        return $this->RateRepository->findBy(
            array('idfilm' => $film->getId())
        );
    }



    /**
     * Delete a Review object
     */
    public function delete(Rate $rate){
        $this->em->remove($rate);
        $this->em->flush();
    }

    /**
     * Save a Review object
     */
    public function save(Rate $rate){
        $this->em->persist($rate);
        $this->em->flush();
    }
}