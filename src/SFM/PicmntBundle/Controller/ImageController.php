<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\User;
use FOS\UserBundle\Entity\UserManager;

class ImageController extends Controller
{

  //@TODO:Delete at the end of the controller developer, is for debug mode only
  //Testing an insertion into the database
  /**
   * @extra:Route("/img/test_add", name="img_add_test")
   */
  public function testAddAction()
  {
    //declare the entity manager
    $em = $this->get('doctrine.orm.entity_manager');
    
    $image = new Image();
    
    $image->setIdImage(999);
    $image->setUserId(1);
    $image->setUrl('add_test');
    
    $em->persist($image);
    $em->flush();

    return $this->redirect($this->generateUrl('secure_home'));
  }


  //Upload an image url into the database

  /************************************************************************
   ************************ UPLOAD ACTTION ********************************
   ***********************************************************************/

  /**
   * @extra:Route("/img/upload", name="img_upload")
   * @extra:Template()
   */
  public function uploadAction()
  {
 
     $image = new Image();
    
    //retrieving the user information 
    $user = $this->container->get('security.context')->getToken()->getUser();
    
    //insert the actual loged User
    $image->setUserId($user->getId());
        
    //calling the form
    $form = $this->get('form.factory')
      ->createBuilder('form', $image)
      ->add('url', 'url')
      //add('FieldName', 'type')
      ->getForm();
    
    //retrieving the request
    $request = $this->get('request');
    
    if ($request->getMethod() == 'POST'){
      $form->bindRequest($request);
      
      if ($form->isValid()) {

	//persist in the database
	$em = $this->get('doctrine.orm.entity_manager');     
   	
	$em->persist($image);
	$em->flush();
	
	return $this->redirect($this->generateUrl('secure_home'));
	
      }
    }
        
    return array('form' => $form->createView(),);
    
  }
  
}
