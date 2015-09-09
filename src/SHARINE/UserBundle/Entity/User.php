<?php

namespace SHARINE\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SHARINE\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
//    public function __construct()
//    {
//        $this->is_archive = 0;
////        $this->salt = 0;
//    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();

        $this->is_archive = 0;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="is_archive", type="integer", options={"default" = 0})
     */
    private $is_archive;

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
     * Set is_archive
     *
     * @param integer $isArchive
     * @return User
     */
    public function setIsArchive($isArchive)
    {
        $this->is_archive = $isArchive;

        return $this;
    }

    /**
     * Get is_archive
     *
     * @return integer 
     */
    public function getIsArchive()
    {
        return $this->is_archive;
    }
}
