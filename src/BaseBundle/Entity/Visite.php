<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visite
 *
 * @ORM\Table(name="visite", indexes={@ORM\Index(name="id_guide", columns={"id_guide"})})
 * @ORM\Entity
 */
class Visite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_visite", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVisite;

    /**
     * @var integer
     *
     * @ORM\Column(name="date", type="integer", nullable=false)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="h_debut", type="integer", nullable=false)
     */
    private $hDebut;

    /**
     * @var integer
     *
     * @ORM\Column(name="h_fin", type="integer", nullable=false)
     */
    private $hFin;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var \Guide
     *
     * @ORM\ManyToOne(targetEntity="Guide")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_guide", referencedColumnName="id")
     * })
     */
    private $idGuide;


}

