<?php

namespace doc\MotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="doc\MotoBundle\Entity\MotoRepository")
 */
class Moto
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
     * @ORM\Column(name="Modele", type="string", length=50)
     */
    private $modele;

	/**
     * @ORM\ManyToOne(targetEntity="doc\MotoBundle\Entity\Marque", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

	/**
     * @ORM\ManyToOne(targetEntity="doc\MotoBundle\Entity\Genre", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $genre;

    /**
     * @var integer
     *
     * @ORM\Column(name="Cylindree", type="integer")
     */
    private $cylindree;

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
     * Set modele
     *
     * @param string $modele
     * @return Moto
     */
    public function setModele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get modele
     *
     * @return string 
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set marque
     *
     * @param \doc\MotoBundle\Entity\Marque $marque
     * @return Moto
     */
    public function setMarque(\doc\MotoBundle\Entity\Marque $marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \doc\MotoBundle\Entity\Marque 
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set genre
     *
     * @param \doc\MotoBundle\Entity\Genre $genre
     * @return Moto
     */
    public function setGenre(\doc\MotoBundle\Entity\Genre $genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \doc\MotoBundle\Entity\Genre 
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set cylindree
     *
     * @param integer $cylindree
     * @return Moto
     */
    public function setCylindree($cylindree)
    {
        $this->cylindree = $cylindree;

        return $this;
    }

    /**
     * Get cylindree
     *
     * @return integer 
     */
    public function getCylindree()
    {
        return $this->cylindree;
    }
	
	/**
     * Get affichage
     *
     * @return string 
     */
    public function getAffichage()
    {
        return $this->marque->getNom().' '.$this->modele;
    }
	
	/**
     * Get nom marque
     *
     * @return string 
     */
    public function getNomMarque()
    {
        return $this->marque->getNom();
    }
}
