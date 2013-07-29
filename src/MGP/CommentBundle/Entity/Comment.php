<?php

namespace MGP\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * MGP\CommentBundle\Entity\ImageComment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity
 */
class Comment
{
    /**
   * @var integer $idComment
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
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
   * @ORM\ManyToOne(targetEntity="\MGP\UserBundle\Entity\User", inversedBy="imageComments", cascade={"detach"})
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * @ORM\ManyToOne(targetEntity="\MGP\ImageBundle\Entity\Image", inversedBy="comments", cascade={"detach"})
   * @ORM\JoinColumn(name="id_image", referencedColumnName="id")
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
     * Get idComment
     *
     * @return integer 
     */
    public function getIdComment()
    {
        return $this->idComment;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return ImageComment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set brightness
     *
     * @param integer $brightness
     * @return ImageComment
     */
    public function setBrightness($brightness)
    {
        $this->brightness = $brightness;
    
        return $this;
    }

    /**
     * Get brightness
     *
     * @return integer 
     */
    public function getBrightness()
    {
        return $this->brightness;
    }

    /**
     * Set contrast
     *
     * @param integer $contrast
     * @return ImageComment
     */
    public function setContrast($contrast)
    {
        $this->contrast = $contrast;
    
        return $this;
    }

    /**
     * Get contrast
     *
     * @return integer 
     */
    public function getContrast()
    {
        return $this->contrast;
    }

    /**
     * Set exposure
     *
     * @param integer $exposure
     * @return ImageComment
     */
    public function setExposure($exposure)
    {
        $this->exposure = $exposure;
    
        return $this;
    }

    /**
     * Get exposure
     *
     * @return integer 
     */
    public function getExposure()
    {
        return $this->exposure;
    }

    /**
     * Set saturation
     *
     * @param integer $saturation
     * @return ImageComment
     */
    public function setSaturation($saturation)
    {
        $this->saturation = $saturation;
    
        return $this;
    }

    /**
     * Get saturation
     *
     * @return integer 
     */
    public function getSaturation()
    {
        return $this->saturation;
    }

    /**
     * Set notified
     *
     * @param integer $notified
     * @return ImageComment
     */
    public function setNotified($notified)
    {
        $this->notified = $notified;
    
        return $this;
    }

    /**
     * Get notified
     *
     * @return integer 
     */
    public function getNotified()
    {
        return $this->notified;
    }

    /**
     * Set email_notified
     *
     * @param integer $emailNotified
     * @return ImageComment
     */
    public function setEmailNotified($emailNotified)
    {
        $this->email_notified = $emailNotified;
    
        return $this;
    }

    /**
     * Get email_notified
     *
     * @return integer 
     */
    public function getEmailNotified()
    {
        return $this->email_notified;
    }

    /**
     * Set user
     *
     * @param \MGPUserBundle\User $user
     * @return ImageComment
     */
    public function setUser(\MGPUserBundle\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \MGPUserBundle\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set image
     *
     * @param \MGPImageBundle\Image $image
     * @return ImageComment
     */
    public function setImage(\MGPImageBundle\Image $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return \MGPImageBundle\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}