<?php

namespace SFM\PicmntBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use SFM\PicmntBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
  public function load($manager)
  {
    $userAdmin = new User();
    $userAdmin->setUsername('admin');
    $userAdmin->setPassword('test');

    $manager->persist($userAdmin);
    $manager->flush();
  }
}
