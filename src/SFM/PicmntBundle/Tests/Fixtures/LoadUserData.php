<?php


namespace SFM\PicmntBundle\Tests\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use SFM\Picmnt\Entity\User;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
  protected $userManager;
 
  public function setContainer(ContainerInterface $container = null)
  {
    $this->userManager = $container->get('fos_user.user_manager');
  }
 
  public function load($em)
  {
    $user = $this->userManager->createUser();
    $user->setUsername('userTest');
    $user->setEmail('test@picmnt.com');
    $user->setPlainPassword('passwordTest');
    $user->setEnabled(true);
    $this->userManager->updateUser($user);
    
  }
}
