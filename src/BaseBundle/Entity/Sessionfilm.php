<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sessionfilm
 *
 * @ORM\Table(name="sessionfilm", indexes={@ORM\Index(name="sessionfilm_ibfk_1", columns={"idfilm"}), @ORM\Index(name="sessionfilm_ibfk_2", columns={"idsalle"})})
 * @ORM\Entity
 */
class Sessionfilm
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idsession", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsession;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=100, nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="datetime", nullable=false)
     */
    private $heure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heurefin", type="datetime", nullable=false)
     */
    private $heurefin;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var \Films
     *
     * @ORM\ManyToOne(targetEntity="Films")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idfilm", referencedColumnName="id")
     * })
     */
    private $idfilm;

    /**
     * @var \Salles
     *
     * @ORM\ManyToOne(targetEntity="Salles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsalle", referencedColumnName="id")
     * })
     */
    private $idsalle;


}

