<?php

namespace doc\MotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Annonce
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="doc\MotoBundle\Entity\AnnonceRepository")
 */
class Annonce
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
     * @ORM\Column(name="Titre", type="string", length=50)
     * @Assert\Length(min=5, minMessage="Le titre doit faire au moins {{ limit }} caractères.")
     */
    private $titre;

    /**
     * @var integer
     *
     * @ORM\Column(name="Annee", type="integer")
     * @Assert\Range(min=1800, max=3000)
     */
    private $annee;

    /**
     * @var integer
     *
     * @ORM\Column(name="Kilometrage", type="integer")
     * @Assert\Range(min=0, max=1000000)
     */
    private $kilometrage;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="Annee_mini", type="integer", nullable=true) 
     * @Assert\Range(min=1800, max=3000)
     */
    private $anneeMini;

    /**
     * @var integer
     *
     * @ORM\Column(name="Kilometrage_maxi", type="integer", nullable=true)
     * @Assert\Range(min=0, max=1000000)
     */
    private $kilometrageMaxi;

    /**
     * @var string
     *
     * @ORM\Column(name="Pseudo", type="string", length=20)
     * @Assert\Length(min=2, minMessage="Le nom doit faire au moins {{ limit }} caractères.")
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="Mail", type="string", length=50)
     * @Assert\Email
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=12, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=255)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Autorisee", type="boolean")
     */
    private $autorisee;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Validee", type="boolean")
     */
    private $validee;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;
	
	/**
     * @var string
     *
     * @ORM\Column(name="codeValidation", type="string", length=50)
     */
    private $codeValidation;

	/**
     * @ORM\ManyToOne(targetEntity="doc\MotoBundle\Entity\Departement", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $departement;

	/**
     * @ORM\ManyToOne(targetEntity="doc\MotoBundle\Entity\Moto", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
	 * @ORM\JoinTable(name="annonce_moto")
     */
    private $moto;

	/**
     * @ORM\ManyToMany(targetEntity="doc\MotoBundle\Entity\Marque", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $marques_voulues;

	/**
     * @ORM\ManyToMany(targetEntity="doc\MotoBundle\Entity\Moto", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
	 * @ORM\JoinTable(name="annonce_motos_voulues")
     */
    private $motos_voulues;

	/**
     * @ORM\ManyToMany(targetEntity="doc\MotoBundle\Entity\Genre", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $genres_voulus;

	/**
     * @ORM\OneToOne(targetEntity="doc\MotoBundle\Entity\Photo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
	 * @ORM\JoinTable(name="annonce_photo1")
	 * @Assert\Valid()
     */
    private $photo1;

	/**
     * @ORM\OneToOne(targetEntity="doc\MotoBundle\Entity\Photo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
	 * @ORM\JoinTable(name="annonce_photo2")
	 * @Assert\Valid()
     */
    private $photo2;

	/**
     * @ORM\OneToOne(targetEntity="doc\MotoBundle\Entity\Photo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
	 * @ORM\JoinTable(name="annonce_photo3")
	 * @Assert\Valid()
     */
    private $photo3;

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
     * Set titre
     *
     * @param string $titre
     * @return Annonce
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set annee
     *
     * @param integer $annee
     * @return Annonce
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return integer 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set kilometrage
     *
     * @param integer $kilometrage
     * @return Annonce
     */
    public function setKilometrage($kilometrage)
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    /**
     * Get kilometrage
     *
     * @return integer 
     */
    public function getKilometrage()
    {
        return $this->kilometrage;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Annonce
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set anneeMini
     *
     * @param integer $anneeMini
     * @return Annonce
     */
    public function setAnneeMini($anneeMini)
    {
        $this->anneeMini = $anneeMini;

        return $this;
    }

    /**
     * Get anneeMini
     *
     * @return integer 
     */
    public function getAnneeMini()
    {
        return $this->anneeMini;
    }

    /**
     * Set kilometrageMaxi
     *
     * @param integer $kilometrageMaxi
     * @return Annonce
     */
    public function setKilometrageMaxi($kilometrageMaxi)
    {
        $this->kilometrageMaxi = $kilometrageMaxi;

        return $this;
    }

    /**
     * Get kilometrageMaxi
     *
     * @return integer 
     */
    public function getKilometrageMaxi()
    {
        return $this->kilometrageMaxi;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     * @return Annonce
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string 
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Annonce
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Annonce
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Annonce
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Annonce
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set autorisee
     *
     * @param boolean $autorisee
     * @return Annonce
     */
    public function setAutorisee($autorisee)
    {
        $this->autorisee = $autorisee;

        return $this;
    }

    /**
     * Get autorisee
     *
     * @return boolean 
     */
    public function getAutorisee()
    {
        return $this->autorisee;
    }

    /**
     * Set departement
     *
     * @param \doc\MotoBundle\Entity\Departement $departement
     * @return Annonce
     */
    public function setDepartement(\doc\MotoBundle\Entity\Departement $departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \doc\MotoBundle\Entity\Departement 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set moto
     *
     * @param \doc\MotoBundle\Entity\Moto $moto
     * @return Annonce
     */
    public function setMoto(\doc\MotoBundle\Entity\Moto $moto)
    {
        $this->moto = $moto;

        return $this;
    }

    /**
     * Get moto
     *
     * @return \doc\MotoBundle\Entity\Moto 
     */
    public function getMoto()
    {
        return $this->moto;
    }

    /**
     * Set motos_voulues
     *
     * @param \doc\MotoBundle\Entity\Moto $motosVoulues
     * @return Annonce
     */
    public function setMotosVoulues(\doc\MotoBundle\Entity\Moto $motosVoulues)
    {
        $this->motos_voulues = $motosVoulues;

        return $this;
    }

    /**
     * Get motos_voulues
     *
     * @return \doc\MotoBundle\Entity\Moto 
     */
    public function getMotosVoulues()
    {
        return $this->motos_voulues;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->motos_voulues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->genres_voulus = new \Doctrine\Common\Collections\ArrayCollection();
        $this->marques_voulues = new \Doctrine\Common\Collections\ArrayCollection();
		$this->date = new \Datetime();
		$this->autorisee = false;
		$this->validee = false;
		$this->codeValidation = substr(md5($this->pseudo.$this->mail.$this->date->format('Y-m-d H:i:s')),0, 50);
		$this->salt = md5(time());
    }
		
    /**
     * Add motos_voulues
     *
     * @param \doc\MotoBundle\Entity\Moto $motosVoulues
     * @return Annonce
     */
    public function addMotosVoulue(\doc\MotoBundle\Entity\Moto $motosVoulues)
    {
        $this->motos_voulues[] = $motosVoulues;

        return $this;
    }

    /**
     * Remove motos_voulues
     *
     * @param \doc\MotoBundle\Entity\Moto $motosVoulues
     */
    public function removeMotosVoulue(\doc\MotoBundle\Entity\Moto $motosVoulues)
    {
        $this->motos_voulues->removeElement($motosVoulues);
    }

    /**
     * Add genres_voulus
     *
     * @param \doc\MotoBundle\Entity\Genre $genresVoulus
     * @return Annonce
     */
    public function addGenresVoulus(\doc\MotoBundle\Entity\Genre $genresVoulus)
    {
        $this->genres_voulus[] = $genresVoulus;

        return $this;
    }

    /**
     * Remove genres_voulus
     *
     * @param \doc\MotoBundle\Entity\Genre $genresVoulus
     */
    public function removeGenresVoulus(\doc\MotoBundle\Entity\Genre $genresVoulus)
    {
        $this->genres_voulus->removeElement($genresVoulus);
    }

    /**
     * Get genres_voulus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenresVoulus()
    {
        return $this->genres_voulus;
    }

    /**
     * Set photo1
     *
     * @param \doc\MotoBundle\Entity\Photo $photo1
     * @return Annonce
     */
    public function setPhoto1(\doc\MotoBundle\Entity\Photo $photo1 = null)
    {
        $this->photo1 = $photo1;

        return $this;
    }

    /**
     * Get photo1
     *
     * @return \doc\MotoBundle\Entity\Photo 
     */
    public function getPhoto1()
    {
        return $this->photo1;
    }

    /**
     * Set photo2
     *
     * @param \doc\MotoBundle\Entity\Photo $photo2
     * @return Annonce
     */
    public function setPhoto2(\doc\MotoBundle\Entity\Photo $photo2 = null)
    {
        $this->photo2 = $photo2;

        return $this;
    }

    /**
     * Get photo2
     *
     * @return \doc\MotoBundle\Entity\Photo 
     */
    public function getPhoto2()
    {
        return $this->photo2;
    }

    /**
     * Set photo3
     *
     * @param \doc\MotoBundle\Entity\Photo $photo3
     * @return Annonce
     */
    public function setPhoto3(\doc\MotoBundle\Entity\Photo $photo3 = null)
    {
        $this->photo3 = $photo3;

        return $this;
    }

    /**
     * Get photo3
     *
     * @return \doc\MotoBundle\Entity\Photo 
     */
    public function getPhoto3()
    {
        return $this->photo3;
    }

    /**
     * Add marques_voulues
     *
     * @param \doc\MotoBundle\Entity\Marque $marquesVoulues
     * @return Annonce
     */
    public function addMarquesVoulues(\doc\MotoBundle\Entity\Marque $marquesVoulues)
    {
        $this->marques_voulues[] = $marquesVoulues;

        return $this;
    }

    /**
     * Remove marques_voulues
     *
     * @param \doc\MotoBundle\Entity\Marque $marquesVoulues
     */
    public function removeMarquesVoulues(\doc\MotoBundle\Entity\Marque $marquesVoulues)
    {
        $this->marques_voulues->removeElement($marquesVoulues);
    }

    /**
     * Get marques_voulues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMarquesVoulues()
    {
        return $this->marques_voulues;
    }

    /**
     * Set codeValidation
     *
     * @param string $codeValidation
     * @return Annonce
     */
    public function setCodeValidation($codeValidation)
    {
        $this->codeValidation = $codeValidation;

        return $this;
    }

    /**
     * Get codeValidation
     *
     * @return string 
     */
    public function getCodeValidation()
    {
        return $this->codeValidation;
    }

    /**
     * Add marques_voulues
     *
     * @param \doc\MotoBundle\Entity\Marque $marquesVoulues
     * @return Annonce
     */
    public function addMarquesVoulue(\doc\MotoBundle\Entity\Marque $marquesVoulues)
    {
        $this->marques_voulues[] = $marquesVoulues;

        return $this;
    }

    /**
     * Remove marques_voulues
     *
     * @param \doc\MotoBundle\Entity\Marque $marquesVoulues
     */
    public function removeMarquesVoulue(\doc\MotoBundle\Entity\Marque $marquesVoulues)
    {
        $this->marques_voulues->removeElement($marquesVoulues);
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Annonce
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }
  
    /**
     * Set validee
     *
     * @param boolean $validee
     * @return Annonce
     */
    public function setValidee($validee)
    {
        $this->validee = $validee;

        return $this;
    }

    /**
     * Get validee
     *
     * @return boolean 
     */
    public function getValidee()
    {
        return $this->validee;
    }
}
