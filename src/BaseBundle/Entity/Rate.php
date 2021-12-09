<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rate
 *
 * @ORM\Table(name="rate", indexes={@ORM\Index(name="rate_ibfk_1", columns={"idfilm"})})
 * @ORM\Entity
 */
class Rate
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idrate", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrate;

    /**
     * @var float
     *
     * @ORM\Column(name="ratee", type="float", precision=10, scale=0, nullable=false)
     */
    private $ratee;

    /**
     * @var \Films
     *
     * @ORM\ManyToOne(targetEntity="Films")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idfilm", referencedColumnName="id")
     * })
     */
    private $idfilm;


}

