<?php

namespace MGP\MainBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use MGP\UserBundle\Entity\User;
use MGP\ImageBundle\Entity\Image;
use MGP\ImageBundle\Entity\Category;
use MGP\CommentBundle\Entity\Comment;

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
            $comment = new Comment();
            $comment->setComment('testComment');
            $comment->setUser($user);
            
            foreach ($ImageData as $property => $value) {
                $image->{'set'.ucfirst($property)}($value);
            }
            $comment->setImage($image);
            $image->setUser($user);
            $em->persist($image);
            $em->persist($comment);
        }
        $em->flush();

        $userDifferent = $this->userManager->createUser();
        $userDifferent->setUsername('userTest2');
        $userDifferent->setEmail('test2@picmnt.com');
        $userDifferent->setPlainPassword('passwordTest2');
        $userDifferent->setEnabled(true);
        $userDifferent->setAvatar('avatarPath');
        $this->userManager->updateUser($userDifferent);

        $image = $em->getRepository('MGPImageBundle:Image')->findOneById(1);
        $commentNew = new Comment();
        $commentNew->setComment('Comment Text');
        $commentNew->setUser($userDifferent);
        $commentNew->setImage($image);
        $em->persist($commentNew);
        $em->flush();
    }

    private function loadImages()
    {
        $images = array();

        $category = new Category();

        $category->setName('others');
        $category->setStatus('1');

        for ($i=1; $i<11; $i++) {
            $images[] = array(
                        'path'         => 'testImage'.$i.'.img',
                        'title'       => 'title_'.$i,
                        'description' => 'description_'.$i,
                        'category'    => $category,
                        'tags'        => 'tags_'.$i,
                        'status'      => '1',
                        'slug'        => 'title_'.$i);
        }

        return $images;
    }
}
