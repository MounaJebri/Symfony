<?php
/**
 * Created by PhpStorm.
 * User: souissi oussama
 * Date: 03/04/2019
 * Time: 18:48
 */

namespace EventBundle\Repository;

use Doctrine\ORM\EntityRepository;
class EventRepository extends EntityRepository
{
    public function TrierEventsSelonNbComm()
    {
        $query = $this->getEntityManager()
            ->createQuery("
        select e 
        FROM BaseBundle:Event e 
        ORDER BY select count(*) FROM BaseBundle:commentaire c WHERE e.id= c.id_event DESC LIMIT 3");

        return $query->getResult();

    }




}