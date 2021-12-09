<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticketstheatre
 *
 * @ORM\Table(name="ticketstheatre", indexes={@ORM\Index(name="id_session", columns={"id_session"}), @ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Ticketstheatre
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
     * @var \Theatre
     *
     * @ORM\ManyToOne(targetEntity="Theatre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_session", referencedColumnName="id_scene")
     * })
     */
    private $idSession;

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

