<?php

namespace BaseBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;
use BaseBundle\Entity\Films;
use Doctrine\ORM\NonUniqueResultException;


class FilmsRepository extends EntityRepository
{

    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM BaseBundle:Films p
                WHERE p.titre LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BaseBundle:Films p ORDER BY p.titre ASC'
            )
            ->getResult();
    }
}
