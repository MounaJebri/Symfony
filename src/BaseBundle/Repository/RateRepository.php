<?php
/**
 * Created by PhpStorm.
 * User: mouna
 * Date: 13/04/2019
 * Time: 19:25
 */

namespace BaseBundle\Repository;
use Doctrine\ORM\EntityRepository;

class RateRepository extends EntityRepository
{
    public function findRateavg($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT AVG(rate) 
                FROM BaseBundle:Rate p
                WHERE p.idfilm LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

}