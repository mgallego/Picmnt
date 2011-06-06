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

class UserController extends Controller
{

  /**
   * @Route("/usr/edit/{userId}", name="usr_edit")
   * @Template()
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

    $form = $this->get('form.factory')
      ->createBuilder('form', $userInfo)
      ->add('name', 'text')
      ->add('last_name', 'text')
      ->getForm();

      //retrieving the request
      $request = $this->get('request');
      
   
      if ($request->getMethod() == 'POST'){
	$form->bindRequest($request);
      

	if ($form->isValid()) {

	  $em->persist($userInfo);
	  $em->flush();

	  return array('form' => $form->createView(), 'userId' => $userId);
	}
      }
      return array('form' => $form->createView(), 'userId' => $userId);


    }
 
     
  }

}