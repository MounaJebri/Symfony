<?php
/**
 * Created by PhpStorm.
 * User: mouna
 * Date: 13/04/2019
 * Time: 12:14
 */

namespace BaseBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;
use BaseBundle\Entity\Sessionfilm;
use Doctrine\ORM\NonUniqueResultException;

class SessionfilmRepository extends EntityRepository
{


    public function findAllOrderedByDate()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p 
                FROM BaseBundle:Sessionfilm p
                ORDER BY p.date ASC ,p.heure ASC '
            )
            ->getResult();
    }


}
