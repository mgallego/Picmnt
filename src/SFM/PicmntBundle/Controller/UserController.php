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
      	  return $this->redirect($this->generateUrl('img_random'));
    }
   else { 

     $userInfo = $em->find('SFMPicmntBundle:UserInfo',$userId);

     if (!$userInfo){
	 $userInfo = new UserInfo();
	 $userInfo->setUserId($user->getId());
     }

     $avatarOld = $userInfo->getAvatar(); 

     $userInfo->setAvatar(null);

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

	  if ($files["avatar"]["file"] == null) {
	    
	    $userInfo->setAvatar($avatarOld);

	  }
	  else{
	  
	    $uploadedFile=$files["avatar"]["file"]; 

	    $uploadedFile->getPath();
	    $uploadedFile->getOriginalName();
	    $uploadedFile->getMimeType();
	    
	    $extension = '.jpg';

	    $newFileName = 'avatar'.$userId.$extension;
	 
	    $uploadedFile->move(
	      $_SERVER['DOCUMENT_ROOT']."/uploads/avatarbig",
	      $newFileName );

	    $imageUtil = new ImageUtil();
	    
	    $imageUtil->resizeImage('uploads/avatarbig/'.$newFileName, 200);
	    $imageUtil->createAvatarSmall('uploads/avatarbig/'.$newFileName, 'uploads/avatarsmall/'.$newFileName, 32);
	 
	    $userInfo->setAvatar($newFileName);
	  }

	  $em->persist($userInfo);
	  $em->flush();
	 
	}
      }
      return $this->render('SFMPicmntBundle:User:editUser.html.twig', array('form' => $form->createView(), 'userId' => $userId, 'avatar'=>$userInfo->getAvatar()));
    }
     
  }

}