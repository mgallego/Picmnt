<?php

namespace SFM\PicmntBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * SFM\PicmntBundle\Entity\ImageComment
 *
 * @ORM\Table(name="Image_Comment")
 * @ORM\Entity
 */
class ImageComment
{

    /**
   * @var integer $idComment
   *
   * @ORM\Column(name="id_comment", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $idComment;


  /**
   *@ var string $comment
   *
   * @ORM\Column(name="comment", type="string", length=255, nullable=false)
   *
   * @Assert\MaxLength(255)
   */
  private $comment;


  /**
   * @ORM\ManyToOne(targetEntity="User", inversedBy="imageComments", cascade={"remove"})
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * @ORM\ManyToOne(targetEntity="Image", inversedBy="imageComments", cascade={"remove"})
   * @ORM\JoinColumn(name="id_image", referencedColumnName="id_image")
   */
  protected $image;

  /**
   * get idComment
   *
   * @return integer $idComment
   */
  public function getIdComment(){
    return $this->idComment;
  }

  /**
   * Set idComment
   *
   * @param integer $idComment
   */
  public function setIdComment($idComment){
    $this->idComment = $idComment;
  }
   
  /**
   * Get comment
   *
   * @return string $comment
   */
  public function getComment()
  {
    return $this->comment;
  }
  

  /**
   * Set comment
   *
   * @param string $comment
   */
  public function setComment($comment)
  {
    $this->comment = $comment;
  }


  /**
   * Set user
   *
   * @param SFM\PicmntBundle\Entity\User $user
   */
  public function setUser(\SFM\PicmntBundle\Entity\User $user)
  {
    $this->user = $user;
  }
  
  /**
   * Get user
   *
   * @return SFM\PicmntBundle\Entity\User $user
   */
  public function getUser()
  {
      return $this->user;
  }


  /**
   * Set image
   *
   * @param SFM\PicmntBundle\Entity\Image $image
   */
  public function setImage(\SFM\PicmntBundle\Entity\Image $image)
  {
    $this->image = $image;
  }
  
  /**
   * Get image
   *
   * @return SFM\PicmntBundle\Entity\Image $image
   */
  public function getImage()
  {
      return $this->image;
  }




}