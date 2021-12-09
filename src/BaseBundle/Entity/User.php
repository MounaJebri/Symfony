<?php

namespace BaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd", type="string", length=100, nullable=true)
     */
    private $pwd;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ddn", type="date", nullable=true)
     */
    private $ddn;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=10, nullable=true)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=20, nullable=true)
     */
    private $tel;

    /**
     * @var integer
     *
     * @ORM\Column(name="ci", type="integer", nullable=true)
     */
    private $ci;

    /**
     * @ORM\OneToMany(targetEntity="ProdFav", mappedBy="idP")
     */
    private $likes;

    public function getLikes()
    {
        return $this->likes = new ArrayCollection();
    }



    /**
     * @return int
     */
    public function getCi()
    {
        return $this->ci;
    }

    /**
     * @param int $ci
     */
    public function setCi($ci)
    {
        $this->ci = $ci;
    }

    /**
     * @return \DateTime
     */
    public function getDdn()
    {
        return $this->ddn;
    }

    /**
     * @param \DateTime $ddn
     */
    public function setDdn($ddn)
    {
        $this->ddn = $ddn;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * @param string $pwd
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }


}

