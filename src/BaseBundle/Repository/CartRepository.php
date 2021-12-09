<?php
/**
 * Created by PhpStorm.
 * User: Khaled
 * Date: 12/04/2019
 * Time: 4:21 PM
 */
namespace BaseBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CartRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BaseBundle:Product p ORDER BY p.name ASC'
            )
            ->getResult();
    }
    public function findAllOrderedByHigh()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BaseBundle:Product p ORDER BY p.price DESC'
            )
            ->getResult();
    }
    public function findAllOrderedByLow()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM BaseBundle:Product p ORDER BY p.price ASC'
            )
            ->getResult();
    }
}