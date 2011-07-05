<?php

namespace SFM\PicmntBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * SFM\PicmntBundle\Entity\UserVote
 *
 * @ORM\Table(name="User_Vote")
 * @ORM\Entity
 */
class UserVote
{

  


  /**
   * @var integer $idVote
   *
   * @ORM\Column(name="id_vote", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $idVote;


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
   * get idVote
   *
   * @return integer $idVote
   */
  public function getIdVote(){
    return $this->idVote;
  }

  /**
   * Set idVote
   *
   * @param integer $idVote
   */
  public function setIdVote($idVote){
    $this->idVote = $idVote;
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
   


}