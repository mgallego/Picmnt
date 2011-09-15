<?php

namespace SFM\PicmntBundle\Tests\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use SFM\PicmntBundle\Entity\User;
use SFM\PicmntBundle\Entity\Image;

class LoadData implements FixtureInterface, ContainerAwareInterface
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

    $images = array(
      1 => array(
	'idImage'    => '1',
	'url'         => 'testImage1.img',
	'title'       => 'title_1',
	'description' => 'description_1',
	'category'    => '1',
	'tags'        => 'tags_1',
	'votes'       => '0'),
      2 => array(
	'idImage'    => '2',
	'url'         => 'testImage2.jpg',
	'title'       => 'title_2',
	'description' => 'description_2',
	'category'    => '1',
	'tags'        => 'tags_2',
	'votes'       => '0'),
      3 => array(
	'idImage'    => '3',
	'url'         => 'testImage3.jpg',
	'title'       => 'title_3',
	'description' => 'description_3',
	'category'    => '1',
	'tags'        => 'tags_1',
	'votes'       => '0'),
      4 => array(
	'idImage'    => '4',
	'url'         => 'testImage4.jpg',
	'title'       => 'title_4',
	'description' => 'description_4',
	'category'    => '1',
	'tags'        => 'tags_1',
	'votes'       => '0'),
      5 => array(
	'idImage'    => '5',
	'url'         => 'testImage5.jpg',
	'title'       => 'title_5',
	'description' => 'description_5',
	'category'    => '1',
	'tags'        => 'tags_1',
	'votes'       => '0'),
      6 => array(
	'idImage'    => '6',
	'url'         => 'testImage6.jpg',
	'title'       => 'title_6',
	'description' => 'description_6',
	'category'    => '1',
	'tags'        => 'tags_1',
	'votes'       => '0'),
      7 => array(
	'idImage'    => '7',
	'url'         => 'testImage7.jpg',
	'title'       => 'title_7',
	'description' => 'description_7',
	'category'    => '1',
	'tags'        => 'tags_1',
	'votes'       => '0'),
      8 => array(
	'idImage'    => '8',
	'url'         => 'testImage8.jpg',
	'title'       => 'title_8',
	'description' => 'description_8',
	'category'    => '1',
	'tags'        => 'tags_1',
	'votes'       => '0'),
      9 => array(
	'idImage'    => '9',
	'url'         => 'testImage9.jpg',
	'title'       => 'title_9',
	'description' => 'description_9',
	'category'    => '1',
	'tags'        => 'tags_1',
	'votes'       => '0'),
      10 => array(
	'idImage'    => '10',
	'url'         => 'testImage10.jpg',
	'title'       => 'title_10',
	'description' => 'description_10',
	'category'    => '1',
	'tags'        => 'tags_1',
	'votes'       => '0'));
      
    foreach ($images as $ref => $ImageData)
      {
	$image = new Image();

	foreach ($ImageData as $property => $value)
	  {
	    $image->{'set'.ucfirst($property)}($value);
	  }

	$image->setUser($user);

	
	$em->persist($image);
      }
    
    $em->flush();



    
  }
}
