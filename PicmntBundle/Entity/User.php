<?php

namespace SFM\PicmntBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

use FOS\UserBundle\Entity\User as BaseUser;

/**
 * PSN\MainBundle\Entity\User
 * @ORM\Entity
 * @ORM\Table(name="User")
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
   * @ORM\OneToMany(targetEntity="Image", mappedBy="userInfo")
   */
  private $images;

  /**
   * @ORM\OneToOne(targetEntity="UserInfo", mappedBy="user")
   */
  private $userInfo;

  
  public function __construct()
  {
    parent::__construct();
    $this->images = new \Doctrine\Common\Collections\ArrayCollection();
  }

    /**
     * Add images
     *
     * @param SFM\PicmntBundle\Entity\Image $images
     */
    public function addPonencias(\SFM\PicmntBundle\Entity\Image $images)
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
    


}