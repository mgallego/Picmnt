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
   * @var integer $idImage
   *
   * @ORM\Column(name="id_image", type="integer", nullable="false")
   *
   */
  private $idImage;

  
  /**
   * @var integer $userId
   *
   * @ORM\Column(name="user_id", type="integer", nullable="false")
   *
   */
  private $userId;

  /**
   *@ var string $comment
   *
   * @ORM\Column(name="comment", type="string", length=255, nullable="false")
   *
   * @Assert\MaxLength(255)
   */
  private $comment;


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
   * get idImage
   *
   * @return integer $idimage
   */
  public function getIdImage(){
    return $this->idImage;
  }

  /**
   * Set idImage
   *
   * @param integer $idImage
   */
  public function setIdImage($idImage){
    $this->idImage = $idImage;
  }

   
  /**
   * Get userId
   *
   * @return integer $userId
   */
  public function getUserId()
  {
    return $this->userId;
  }
  

  /**
   * Set userId
   *
   * @param integer $userId
   */
  public function setUserId($userId)
  {
    $this->userId = $userId;
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

}