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
   * @ORM\Column(name="comment", type="string", length=2000, nullable=false)
   *
   * @Assert\Length(max = "2000")
   */
  private $comment;


  /**
   * @ORM\ManyToOne(targetEntity="User", inversedBy="imageComments", cascade={"detach"})
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * @ORM\ManyToOne(targetEntity="Image", inversedBy="imageComments", cascade={"detach"})
   * @ORM\JoinColumn(name="id_image", referencedColumnName="id_image")
   */
  protected $image;
  
  /**
   * @var integer $brightness
   *
   * @ORM\Column(name="brightness", type="integer", nullable=true)
   */
  protected $brightness;

   /**
   * @var integer $contrast
   *
   * @ORM\Column(name="contrast", type="integer", nullable=true)
   */
  protected $contrast;

   /**
   * @var integer $exposition
   *
   * @ORM\Column(name="exposure", type="integer", nullable=true)
   */
  protected $exposure;

   /**
   * @var integer $saturation
   *
   * @ORM\Column(name="saturation", type="integer", nullable=true)
   */
  protected $saturation;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  protected $notified;

  /**
   * @ORM\Column(type="integer", nullable=true)
   *
   */
  protected $email_notified;
  

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

  public function setBrightness($brightness)
  {
    $this->brightness = $brightness;
  }

  public function getBrightness()
  {
    return $this->brightness;
  }

  public function setContrast($contrast)
  {
    $this->contrast = $contrast;
  }

  public function getContrast()
  {
    return $this->contrast;
  }

  public function setExposure($exposure)
  {
    $this->exposure = $exposure;
  }

  public function getExposure()
  {
    return $this->exposure;
  }
  public function setSaturation($saturation)
  {
    $this->saturation = $saturation;
  }

  public function getSaturation()
  {
    return $this->saturation;
  }

  public function setNotified($notified){
    $this->notified = $notified;
  }

  public function getNotified(){
    return $this->notified;
  }
 
  /**
   * Set email_notified
   *
   * @param integer $emailNotified
   */
   public function setEmailNotified($emailNotified){
    $this->email_notified = $emailNotified;
  }

 
   public function getEmailNotifed(){
     return  $this->email_notified;
   }


}