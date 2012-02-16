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

    public function editAction($userId){
    
	$userInfo = new UserInfo();

	$em = $this->get('doctrine')->getEntityManager();     

	$user = $this->container->get('security.context')->getToken()->getUser();

	if ($user->getId() != $userId) { 
	  return $this->redirect($this->generateUrl('img_show', array("option"=>"random")));
	}
	else { 

	    $userInfo = $em->find('SFMPicmntBundle:UserInfo',$userId);
     
	    if (!$userInfo){
		$userInfo = new UserInfo();
		$userInfo->setUserId($user->getId());
	    }

	    $avatarOld = $userInfo->getAvatar(); 


	    $form = $this->get('form.factory')
		->createBuilder('form', $userInfo)
		->add('name', 'text')
		->add('last_name', 'text')
		->add('avatar', 'file', array('required'=>false))
		->getForm();

	    $request = $this->get('request');
   
	    if ($request->getMethod() == 'POST'){
		$form->bindRequest($request);
      
		if ($form->isValid()) {

		    $files=$request->files->get($form->getName());

		    if ($files["avatar"] == null) {
	    
			$userInfo->setAvatar($avatarOld);

		    }
		    else{
	  
			$uploadedFile=$files["avatar"]; 

			$uploadedFile->getPath();
			$uploadedFile->getClientOriginalName();
			$uploadedFile->getMimeType();
	    
			$extension = '.jpg';

			$newFileName = 'avatar'.$userId.$extension;
	 
			$uploadedFile->move(
			    $_SERVER['DOCUMENT_ROOT']."/uploads/avatarbig",
			    $newFileName );

			$imageUtil = new ImageUtil();
	    
			$imageUtil->resizeImage('uploads/avatarbig/'.$newFileName, 200);
			$imageUtil->createImageSmall('uploads/avatarbig/'.$newFileName, 'uploads/avatarsmall/'.$newFileName, 32);
	 
			$userInfo->setAvatar($newFileName);
		    }

		    $em->persist($userInfo);
		    $em->flush();
	 
		}
	    }
	    $response =  $this->render('SFMPicmntBundle:User:editUser.html.twig', array('form' => $form->createView(), 'userId' => $userId, 'avatar'=>$userInfo->getAvatar()));
	    $response->setMaxAge(0);
	    return $response;
	}
    }


    public function  profileAction($userName){
      $em = $this->get('doctrine')->getEntityManager();
      $user =   $em->getRepository('SFMPicmntBundle:User')->findOneByUsername($userName);

      if (!$user){
	  $e = $this->get('translator')->trans('The User Not Exists');
	  throw $this->createNotFoundException($e);
      }

      $avatarOld = $user->getAvatar();

      $paginator = $this->get('ideup.simple_paginator');
  
      $paginator->setItemsPerPage(10);

      $images = $paginator->paginate($em->getRepository('SFMPicmntBundle:Image')->getByUserDQL($userName))->getResult();



      $form = $this->get('form.factory')
	->createBuilder('form', $user)
	->add('avatar', 'file', array('required'=>false))
	->getForm();

      $request = $this->get('request');
   
      if ($request->getMethod() == 'POST'){
	$form->bindRequest($request);
      
	if ($form->isValid()) {

	  $files=$request->files->get($form->getName());

	  if ($files["avatar"] == null) {
	    
	    $user->setAvatar($avatarOld);

	  }
	  else{
	  
	    $uploadedFile=$files["avatar"]; 

	    $uploadedFile->getPath();
	    $uploadedFile->getClientOriginalName();
	    $uploadedFile->getMimeType();
	    
	    $extension = '.jpg';

	    $newFileName = 'avatar'.$user->getId().$extension;
	 
	    $uploadedFile->move(
	      $_SERVER['DOCUMENT_ROOT']."/uploads/avatarbig",
	      $newFileName );

	    $imageUtil = new ImageUtil();
	    
	    $imageUtil->resizeImage('uploads/avatarbig/'.$newFileName, 300);
	    $imageUtil->createAvatarSmall('uploads/avatarbig/'.$newFileName, 'uploads/avatarsmall/'.$newFileName, 50);
	 
	    $user->setAvatar($newFileName);
	  }

	  $em->persist($user);
	  $em->flush();
	}
      }

      if ($images){
	return $this->render('SFMPicmntBundle:User:profile.html.twig', array('images' => $images, 'form' => $form->createView()));

      }
      else{
	return $this->render('SFMPicmntBundle:User:profile.html.twig', array('images' => $images, 'form' => $form->createView()));
      }
    }

    public function  pendingAction($userName){
      $em = $this->get('doctrine')->getEntityManager();

      $em = $this->get('doctrine')->getEntityManager();     

      $user = $this->container->get('security.context')->getToken()->getUser();

      if ($user->getUsername() != $userName) { 
	return $this->redirect($this->generateUrl('img_show', array("option"=>"random", "category"=>"all")));
      }

      $paginator = $this->get('ideup.simple_paginator');
  
      $paginator->setItemsPerPage(10);

      $images = $paginator->paginate($em->getRepository('SFMPicmntBundle:User')->getPendingCommentsDQL($userName))->getResult();

      return $this->render('SFMPicmntBundle:User:pending.html.twig', array('images' => $images));

    }

}