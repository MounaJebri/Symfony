<?php
/**
 * Created by PhpStorm.
 * User: souissi oussama
 * Date: 03/04/2019
 * Time: 18:47
 */

namespace EventBundle\Repository;


class CommentaireRepository extends \Doctrine\ORM\EntityRepository
{
    public function NbComm($type)
    {
        $query = $this->getEntityManager()
            ->createQuery("
        select count(c.id) from BaseBundle:Commentaire c JOIN BaseBundle:event e where c.idEvent = e.id and e.typeEvent=:type")
        ->setParameter('type',$type);


        return $query->getSingleScalarResult();

        /*$qb = $this->_em->createQueryBuilder();
        $qb->select('count(c.id)')
            ->from('BaseBundle:Commentaire','c')
            ->join('BaseBundle:Event','e')
            ->where('e.typeEvent=:type')
            ->setParameter('type',$type);
        $totalNbComm = $qb->getQuery()->getSingleScalarResult();
        return $totalNbComm;*/
    }


}