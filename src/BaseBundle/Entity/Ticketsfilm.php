<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticketsfilm
 *
 * @ORM\Table(name="ticketsfilm", indexes={@ORM\Index(name="id_sesion", columns={"id_sesion"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Ticketsfilm
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Sessionfilm
     *
     * @ORM\ManyToOne(targetEntity="Sessionfilm")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sesion", referencedColumnName="idsession")
     * })
     */
    private $idSesion;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;


}

