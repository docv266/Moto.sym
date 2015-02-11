<?php

namespace doc\MotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="doc\MotoBundle\Entity\DepartementRepository")
 */
class Departement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="CP", type="string", length=3)
     */
    private $cp;

	/**
     * @ORM\ManyToOne(targetEntity="doc\MotoBundle\Entity\Region", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Departement
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     * @return Departement
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set region
     *
     * @param \doc\MotoBundle\Entity\Region $region
     * @return Departement
     */
    public function setRegion(\doc\MotoBundle\Entity\Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \doc\MotoBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }
	
	/**
     * Get affichage
     *
     * @return string 
     */
    public function getAffichage()
    {
        return $this->cp.' '.$this->nom;
    }
}
