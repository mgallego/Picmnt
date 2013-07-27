<?php

namespace MGP\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use FOS\UserBundle\Entity\User as BaseUser;

/**
 * MGP\UserBundle\Entity\User
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="MGP\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\OneToMany(targetEntity="\MGP\ImageBundle\Entity\Image", mappedBy="user", cascade={"persist"})
   */
  private $images;

  /**
   * @ORM\OneToOne(targetEntity="UserInfo", mappedBy="user", cascade={"persist"})
   */
  private $userInfo;

  /**
   * @ORM\OneToMany(targetEntity="\MGP\CommentBundle\Entity\Comment", mappedBy="user", cascade={"persist"})
   */
  private $imageComments;

  /**
   * @var string $avatar
   *
   * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
   */
  private $avatar;

  
  public function __construct()
  {
    parent::__construct();
    $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    $this->imageComments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set avatar
     *
     * @param string $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    
        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Add images
     *
     * @param \MGP\ImageBundle\Entity\Image $images
     * @return User
     */
    public function addImage(\MGP\ImageBundle\Entity\Image $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \MGP\ImageBundle\Entity\Image $images
     */
    public function removeImage(\MGP\ImageBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set userInfo
     *
     * @param \MGP\UserBundle\Entity\UserInfo $userInfo
     * @return User
     */
    public function setUserInfo(\MGP\UserBundle\Entity\UserInfo $userInfo = null)
    {
        $this->userInfo = $userInfo;
    
        return $this;
    }

    /**
     * Get userInfo
     *
     * @return \MGP\UserBundle\Entity\UserInfo 
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * Add imageComments
     *
     * @param \MGP\CommentBundle\Entity\Comment $imageComments
     * @return User
     */
    public function addImageComment(\MGP\CommentBundle\Entity\Comment $imageComments)
    {
        $this->imageComments[] = $imageComments;
    
        return $this;
    }

    /**
     * Remove imageComments
     *
     * @param \MGP\CommentBundle\Entity\Comment $imageComments
     */
    public function removeImageComment(\MGP\CommentBundle\Entity\Comment $imageComments)
    {
        $this->imageComments->removeElement($imageComments);
    }

    /**
     * Get imageComments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImageComments()
    {
        return $this->imageComments;
    }
}