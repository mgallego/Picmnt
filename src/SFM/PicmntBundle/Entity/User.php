<?php

namespace SFM\PicmntBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use FOS\UserBundle\Entity\User as BaseUser;

/**
 * PSN\MainBundle\Entity\User
 * @ORM\Entity
 * @ORM\Table(name="User")
 * @ORM\Entity(repositoryClass="SFM\PicmntBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\generatedValue(strategy="AUTO")
   */
  protected $id;


  /**
   * @ORM\OneToMany(targetEntity="Image", mappedBy="user", cascade={"persist"})
   */
  private $images;

  /**
   * @ORM\OneToOne(targetEntity="UserInfo", mappedBy="user", cascade={"persist"})
   */
  private $userInfo;

  /**
   * @ORM\ManyToMany(targetEntity="Image", mappedBy="userVotes")
   */
  protected $imageVotes;

  /**
   * @ORM\OneToMany(targetEntity="ImageComment", mappedBy="user", cascade={"persist"})
   */
  private $imageComments;


  /**
   * @var string $avatar
   *
   * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
   */
  private $avatar;


  ////////////////////////////////////////////
  ///////////  METHODS  //////////////////////
  ////////////////////////////////////////////

  
  public function __construct()
  {
    parent::__construct();
    $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    $this->imageVotes = new \Doctrine\Common\Collections\ArrayCollection();
    $this->imageComments = new \Doctrine\Common\Collections\ArrayCollection();
  }

    /**
     * Add images
     *
     * @param SFM\PicmntBundle\Entity\Image $images
     */
    public function addImages(\SFM\PicmntBundle\Entity\Image $images)
    {
      $this->images[] = $images;
    }

    /**
     * Get images
     *
     * @return SFM\PicmntBundle\Entity\Image $images
     */
    public function getImages()
    {
      return $this->images;
    }

     /**
     * Set userInfo
     *
     * @param SFM\PicmntBundle\Entity\UserInfo $userInfo
     */
    public function setUserInfo(\SFM\PicmntBundle\Entity\UserInfo $userInfo)
    {
      $this->userInfo = $userInfo;
    }


    /**
     * Get userInfo
     *
     * @return SFM\PicmntBundle\Entity\UserInfo $userInfo
     */
    public function getUserInfo()
    {
      return $this->userInfo;
    }

    /**
     * Add imageVotes
     *
     * @param SFM\PicmntBundle\Entity\Image $imageVotes
     */
    public function addImageVites(\SFM\PicmntBundle\Entity\Image $imageVotes)
    {
      if (!$this->hasImage($imageVotes)){
	$this->imageVites[] = $imageVotes;
	return true;
      }
      
      return false;
    }

    public function hasImage(\SFM\PicmntBundle\Entity\Image $image)
    {

      foreach ($this->imageVotes as $value)
	{
	  if ($value->getIdImage() == $image->getIdImage())
	    {
	      return true;
	    }
	}
      return false;
    }
      

    /**
     * Get userVotes
     *
     * @return SFM\PicmnBundle\Entity\Image $imageVotes
     */
    public function getImageVotes()
    {
      return $this->imageVotes;
    }
 
    /**
     * Add imageComments
     *
     * @param SFM\PicmntBundle\Entity\ImageComment $imageComments
     */
    public function addImageComments(\SFM\PicmntBundle\Entity\ImageComment $imageComments)
    {
      $this->imageComments[] = $imageComments;
    }

    /**
     * Get imageComments
     *
     * @return SFM\PicmntBundle\Entity\Image $imageComments
     */
    public function getImageComments()
    {
      return $this->imageComments;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     */
    public function setAvatar($avatar){
      $this->avatar = $avatar;
    }

    /**
     * Get avatar
     *
     * @return string $avatar
     */
    public function getAvatar(){
      return $this->avatar;
    }

   
}