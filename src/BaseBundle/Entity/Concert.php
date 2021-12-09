<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Concert
 *
 * @ORM\Table(name="concert")
 * @ORM\Entity
 */
class Concert
{
    /**
     * @var string
     *
     * @ORM\Column(name="liste_artistes", type="string", length=300, nullable=false)
     */
    private $listeArtistes;

    /**
     * @var string
     *
     * @ORM\Column(name="type_concert", type="string", length=30, nullable=false)
     */
    private $typeConcert;

    /**
     * @var \Event
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Event")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $id;


}

