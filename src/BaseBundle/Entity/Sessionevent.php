<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sessionevent
 *
 * @ORM\Table(name="sessionevent", indexes={@ORM\Index(name="id_event", columns={"id_event"}), @ORM\Index(name="id_salle", columns={"id_salle"})})
 * @ORM\Entity
 */
class Sessionevent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_session", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSession;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deb", type="datetime", nullable=false)
     */
    private $dateDeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=false)
     */
    private $dateFin;

    /**
     * @var \Event
     *
     * @ORM\ManyToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_event", referencedColumnName="id")
     * })
     */
    private $idEvent;

    /**
     * @var \Salles
     *
     * @ORM\ManyToOne(targetEntity="Salles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_salle", referencedColumnName="id")
     * })
     */
    private $idSalle;


}

