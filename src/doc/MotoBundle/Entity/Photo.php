<?php

namespace doc\MotoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Photo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="doc\MotoBundle\Entity\PhotoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Photo
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;
	
    /**
	 * @Assert\Image(minWidth=100, maxWidth=1000, minHeight=100, maxHeight=1000, mimeTypesMessage="Doit être une image valide.", sizeNotDetectedMessage="Mauvaise taille", maxSize="3M", maxSizeMessage="Votre fichier est trop gros: ({{ size }} > {{ limit }}).")
     */
	private $file;
	
	/**
     * @ORM\ManyToOne(targetEntity="doc\MotoBundle\Entity\Annonce", inversedBy="photos")
     * @ORM\JoinColumn(nullable=true)
	 * @Assert\Valid()
     */
    private $annonce;
	
	private $tempFilename;
  
	public function getFile()
	{
		return $this->file;
	}

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
     * Set url
     *
     * @param string $url
     * @return Photo
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    	
	// On modifie le setter de File, pour prendre en compte l'upload d'un fichier lorsqu'il en existe déjà un autre
    public function setFile(UploadedFile $file)
    {
		$this->file = $file;

		// On vérifie si on avait déjà un fichier pour cette entité
		if (null !== $this->url) {
		  // On sauvegarde l'extension du fichier pour le supprimer plus tard
		  $this->tempFilename = $this->url;

		  // On réinitialise les valeurs des attributs url et alt
		  $this->url = null;
		  $this->alt = null;
		}
    }

	  /**
	   * @ORM\PrePersist()
	   * @ORM\PreUpdate()
	   */
	public function preUpload()
	{
		// Si jamais il n'y a pas de fichier (champ facultatif)
		if (null === $this->file) {
		  return;
		}

		// Le nom du fichier est son id, on doit juste stocker également son extension
		// Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « url »
		$this->url = $this->file->guessExtension();

		// Et on génère l'attribut alt de la balise <img>, à la valeur du nom du fichier sur le PC de l'internaute
		$this->alt = $this->file->getClientOriginalName();
	}

	  /**
	   * @ORM\PostPersist()
	   * @ORM\PostUpdate()
	   */
	public function upload()
	{
		// Si jamais il n'y a pas de fichier (champ facultatif)
		if (null === $this->file) {
		  return;
		}

		// Si on avait un ancien fichier, on le supprime
		if (null !== $this->tempFilename) {
		  $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
		  if (file_exists($oldFile)) {
			unlink($oldFile);
		  }
		}

		// On déplace le fichier envoyé dans le répertoire de notre choix
		$this->file->move(
		  $this->getUploadRootDir(), // Le répertoire de destination
		  $this->id.'.'.$this->url   // Le nom du fichier à créer, ici « id.extension »
		);
	}

	  /**
	   * @ORM\PreRemove()
	   */
	public function preRemoveUpload()
	{
		// On sauvegarde temporairement le nom du fichier, car il dépend de l'id
		$this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
	}

	  /**
	   * @ORM\PostRemove()
	   */
	public function removeUpload()
	{
		// En PostRemove, on n'a pas accès à l'id, on utilise notre nom sauvegardé
		if (file_exists($this->tempFilename)) {
		  // On supprime le fichier
		  unlink($this->tempFilename);
		}
	}

	public function getUploadDir()
	{
		// On retourne le chemin relatif vers l'image pour un navigateur
		return 'uploads/img';
	}

	protected function getUploadRootDir()
	{
		// On retourne le chemin relatif vers l'image pour notre code PHP
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	
	public function getWebPath()
    {
		return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Photo
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
    }
	
	public function getLabel()
    {
		return 'Photo';
    }

   
    /**
     * Set annonce
     *
     * @param \doc\MotoBundle\Entity\Annonce $annonce
     * @return Photo
     */
    public function setAnnonce(\doc\MotoBundle\Entity\Annonce $annonce = null)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \doc\MotoBundle\Entity\Annonce 
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }
}
