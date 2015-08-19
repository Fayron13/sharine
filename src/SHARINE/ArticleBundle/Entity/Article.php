<?php

namespace SHARINE\ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SHARINE\ArticleBundle\Entity\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="titre", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "5",
     *      max = "50",
     *      minMessage = "Votre titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="resume", type="string", length=200)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "20",
     *      max = "200",
     *      minMessage = "Votre resume doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre resume ne peut pas être plus long que {{ limit }} caractères"
     * )
     */
    private $resume;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="mainArticle", type="text")
     */
    private $mainArticle;

    /**
     * @ORM\ManyToOne(targetEntity="SHARINE\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="SHARINE\CategorieBundle\Entity\Categorie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;


    /**
     * @ORM\OneToOne(targetEntity="SHARINE\ArticleBundle\Entity\Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     *  @Assert\Image(
     *     minWidth = 200,
     *     minHeight = 200,
     * )
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpeg", "image/jpeg" , "image/png"},
     *     mimeTypesMessage = "Choisissez une image avec un mimeType valide. (jpg, jpeg, png)"
     * )     */
    private $file;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_active", type="integer", options={"default" = 0})
     */
    private $is_active;

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
     * @return Article
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
     * Set date
     *
     * @param \DateTime $date
     * @return Article
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
     * Set resume
     *
     * @param string $resume
     * @return Article
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string 
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set categorie
     *
     * @param \SHARINE\CategorieBundle\Entity\Categorie $categorie
     * @return Article
     */
    public function setCategorie(\SHARINE\CategorieBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \SHARINE\CategorieBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }


    public function setFile(\SHARINE\ArticleBundle\Entity\Image $file = null)
    {
        $this->file = $file;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }


    /**
     * Set image
     *
     * @param \SHARINE\ArticleBundle\Entity\Image $image
     * @return Article
     */
    public function setImage(\SHARINE\ArticleBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \SHARINE\ArticleBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Set user
     *
     * @param \SHARINE\UserBundle\Entity\User $user
     * @return Article
     */
    public function setUser(\SHARINE\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SHARINE\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set is_active
     *
     * @param integer $isActive
     * @return Article
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get is_active
     *
     * @return integer 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set mainArticle
     *
     * @param string $mainArticle
     * @return Article
     */
    public function setMainArticle($mainArticle)
    {
        $this->mainArticle = $mainArticle;

        return $this;
    }

    /**
     * Get mainArticle
     *
     * @return string 
     */
    public function getMainArticle()
    {
        return $this->mainArticle;
    }
}
