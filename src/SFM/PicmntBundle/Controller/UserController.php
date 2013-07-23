<?php 

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SFM\PicmntBundle\Entity\User;
use SFM\PicmntBundle\Entity\UserInfo;
use FOS\UserBundle\Entity\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\Query\ResultSetMapping;
use SFM\PicmntBundle\Util\ImageUtil;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;


class UserController extends Controller
{
    /**
     * Show the profile and change avatar
     *
     */
    public function profileAction($userName = null){
	$em = $this->get('doctrine')->getManager();
	$user = $this->getUser($userName);
        
	if (!$user){
	    $e = $this->get('translator')->trans('The User Not Exists');
	    throw $this->createNotFoundException($e);
	}

        $avatarOld = $user->getAvatar();

        $images = $em->getRepository('SFMPicmntBundle:Image')
            ->getByUsername($user->getUsername(), null, $this->container->getParameter('images_per_page'));

        $loadMore = true;
        if (count($images) < $this->container->getParameter('images_per_page')) {
            $loadMore = false;
        }

	$form = $this->getAvatarForm($user);

	$request = $this->get('request');

	if ($request->getMethod() == 'POST'){
	    $form->bindRequest($request);
      
	    if ($form->isValid()) {
		$files = $request->files->get($form->getName());

		if ($files["avatar"] === null) {
		    $user->setAvatar($avatarOld);
		}
		else{
		    $avatarDefaults = $this->container->getParameter('avatar_defaults');
		    $imageUtil = $this->container->get('image.utils');

		    $newFileName = 'avatar'.$user->getId().$avatarDefaults['extension'];	    
		    $imageUtil->uploadFile($files["avatar"], $avatarDefaults['upload_big_path'], $newFileName);

		    $imageUtil->resizeImage($avatarDefaults['upload_big_path'].$newFileName, $avatarDefaults['big_size']);

                    if (!is_dir($avatarDefaults['upload_big_path'])) {
                        mkdir($avatarDefaults['upload_big_path']);
                    }


                    if (!is_dir($avatarDefaults['upload_small_path'])) {
                        mkdir($avatarDefaults['upload_small_path']);
                    }

		    $imageUtil->createImageSmall($avatarDefaults['upload_big_path'].$newFileName, $avatarDefaults['upload_small_path'].$newFileName, $avatarDefaults['small_size']);	 
		    $user->setAvatar($newFileName);
		}
		$em->persist($user);
		$em->flush();
	    }
	}
	return $this->render('SFMPicmntBundle:User:profile.html.twig', array('images' => $images, 'form' => $form->createView(), 'user' => $user, 'loadMore'=> $loadMore));
    }



    /**
     * Return a form to upload an avatar image
     *
     */
    private function getAvatarForm($user)
    {
	return $this->get('form.factory')
	    ->createBuilder('form')
	    ->add('avatar', 'file', array('required'=>false))
	    ->getForm();
    }


    private function pendingAction($userName){
	$em = $this->get('doctrine')->getManager();     
	$user = $this->container->get('security.context')->getToken()->getUser();

	if (!$this->getUser($userName)){
	    $e = $this->get('translator')->trans('The User Not Exists');
	    throw $this->createNotFoundException($e);
	}

	if ($user->getUsername() != $userName) { 
	    return $this->redirect($this->generateUrl('img_show', array("option"=>"random", "category"=>"all")));
	}
	$paginator = $this->get('ideup.simple_paginator');
	$paginator->setItemsPerPage(10);
	$images = $paginator->paginate($em->getRepository('SFMPicmntBundle:User')->getPendingCommentsDQL($userName))->getResult();

	return $this->render('SFMPicmntBundle:User:pending.html.twig', array('images' => $images));
    }

}