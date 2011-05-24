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


  public function __construct()
  {
    parent::__construct();
    // your own logic
  }


}