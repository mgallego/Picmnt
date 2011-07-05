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
   * @Route("/usr/edit/{userId}", name="usr_edit")
   * @Template()
   * @Cache(maxage=1)
   */
  public function editUserAction($userId){
    
    $userInfo = new UserInfo();

    $em = $this->get('doctrine')->getEntityManager();     

    $user = $this->container->get('security.context')->getToken()->getUser();

    //compare the actual user and the property of the image
    if ($user->getId() != $userId) { //diferent user
      	  return $this->redirect($this->generateUrl('img_random'));
    }
   else { 

     $userInfo = $em->find('SFMPicmntBundle:UserInfo',$userId);

     $avatarOld = $userInfo->getAvatar(); //obtain the old avatar

     $userInfo->setAvatar(null);

     $form = $this->get('form.factory')
       ->createBuilder('form', $userInfo)
       ->add('name', 'text')
       ->add('last_name', 'text')
       ->add('avatar', 'file', array('required'=>false))
       ->getForm();

      //retrieving the request
      $request = $this->get('request');
      
   
      if ($request->getMethod() == 'POST'){
	$form->bindRequest($request);
      
	if ($form->isValid()) {

	  //avatar
	  $files=$request->files->get($form->getName());

	  if ($files["avatar"]["file"] == null) {
	    
	    $userInfo->setAvatar($avatarOld);

	  }
	  else{
	  
	    $uploadedFile=$files["avatar"]["file"]; //"dataFile" is the name on the field

	    //once you have the uploadedFile object there is some sweet functions you can run
	    $uploadedFile->getPath();//returns current (temporary) path
	    $uploadedFile->getOriginalName();
	    $uploadedFile->getMimeType();
	    
	    
	    //rerieving the file extension
	    /*
	    if ($uploadedFile->getMimeType() == 'image/png' ){
	      $extension = '.png';
	    }
	    else{
	      $extension = '.jpg';
	    }
	    */
	    $extension = '.jpg';
	    //creating a new name for the file
	    $newFileName = 'avatar'.$userId.$extension;
	    
	    //and most important is move(),
	    $uploadedFile->move(
	      $_SERVER['DOCUMENT_ROOT']."/uploads/avatarbig",
	      $newFileName );
	    

	    $imageUtil = new ImageUtil();
	    
	    //resize the image if is necesary
	    $imageUtil->resizeImage('uploads/avatarbig/'.$newFileName, 200);
	  
	    $imageUtil->createAvatarSmall('uploads/avatarbig/'.$newFileName, 'uploads/avatarsmall/'.$newFileName, 32);

	    //save the url of the image (name) into the database
	    $userInfo->setAvatar($newFileName);
	    
	    
	  }

	  $em->persist($userInfo);
	  $em->flush();
	 
	  return array('form' => $form->createView(), 'userId' => $userId, 'avatar'=>$userInfo->getAvatar());
	}
      }
      return array('form' => $form->createView(), 'userId' => $userId, 'avatar'=>$avatarOld);

    }
     
  }

}