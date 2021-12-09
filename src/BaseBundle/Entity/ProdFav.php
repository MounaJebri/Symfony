<?php

namespace BaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProdFav
 *
 * @ORM\Table(name="prod_fav")
 * @ORM\Entity(repositoryClass="BaseBundle\Repository\ProdFavRepository")
 */
class ProdFav
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $idU;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product",inversedBy="likes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit", referencedColumnName="id")
     * })
     */
    private $idP;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \User
     */
    public function getIdU()
    {
        return $this->idU;
    }

    /**
     * @param \User $idU
     */
    public function setIdU($idU)
    {
        $this->idU = $idU;
    }

    /**
     * @return \Product
     */
    public function getIdP()
    {
        return $this->idP;
    }

    /**
     * @param \Product $idP
     */
    public function setIdP($idP)
    {
        $this->idP = $idP;
    }

}

