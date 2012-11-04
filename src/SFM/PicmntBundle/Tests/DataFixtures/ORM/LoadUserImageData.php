<?php

namespace SFM\PicmntBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use SFM\PicmntBundle\Entity\User;
use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\Category;

class LoadUserImageData implements FixtureInterface, ContainerAwareInterface
{
    protected $userManager;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->userManager = $container->get('fos_user.user_manager');
    }

    public function load(ObjectManager $em)
    {
        $user = $this->userManager->createUser();
        $user->setUsername('userTest');
        $user->setEmail('test@picmnt.com');
        $user->setPlainPassword('passwordTest');
        $user->setEnabled(true);
        $this->userManager->updateUser($user);

        $category = new Category();

        $category->setName('others');
        $category->setStatus('1');

        $images = $this->loadImages();

        foreach ($images as $ref => $ImageData) {
            $image = new Image();

            foreach ($ImageData as $property => $value) {
                $image->{'set'.ucfirst($property)}($value);
            }

            $image->setUser($user);
            $em->persist($image);
        }
        $em->flush();
    }

    private function loadImages()
    {
        $images = array();

        $category = new Category();

        $category->setName('others');
        $category->setStatus('1');

        for ($i=1; $i<11; $i++) {
            $images[] = array('idImage'    => $i,
                        'url'         => 'testImage'.$i.'.img',
                        'title'       => 'title_'.$i,
                        'description' => 'description_'.$i,
                        'category'    => $category,
                        'tags'        => 'tags_'.$i,
                        'status'      => '1',
                        'votes'       => '0');
        }

        return $images;
    }
}
