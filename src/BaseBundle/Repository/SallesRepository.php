<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 13/04/2019
 * Time: 23:59
 */

namespace BaseBundle\Repository;


class SallesRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BaseBundle:Salles p ORDER BY p.name ASC'
            )
            ->getResult();
    }

    public function findEventsNumberBySalle($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT count(p) FROM BaseBundle:Sessionevent where p.idSalle = :id")->setParameter('id','%'.$id.'%')
            ->getResult();
    }
    public function findfilmNumberBySalle($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT count(p) FROM BaseBundle:Sessionfilm where p.idsalle = :id")->setParameter('id','%'.$id.'%')
            ->getResult();
    }
    public function findtheatreNumberBySalle($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT count(p) FROM BaseBundle:Sessiontheatre where p.idSalle = :id")->setParameter('id','%'.$id.'%')
            ->getResult();
    }


}