<?php
namespace SFM\PicmntBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;

/**
 * PSN\MainBundle\Entity\User
 * @orm:Entity
 */
class User extends BaseUser
{
  /**
   * @orm:Id
   * @orm:Column(type="integer")
   * @orm:generatedValue(strategy="AUTO")
   */
  protected $id;
}