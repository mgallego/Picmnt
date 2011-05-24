<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\User;
use FOS\UserBundle\Entity\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class ImageController extends Controller
{
  
  /************************************************************************
   ************************ UPLOAD ACTTION ********************************
   ************************************************************************
   ************** Upload an image url into the database *******************
   ***********************************************************************/

  /**
   * @Route("/img/upload", name="img_upload")
   * @Template()
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
	$em = $this->get('doctrine')->getEntityManager();     
   	
	$em->persist($image);
	$em->flush();
	
	return $this->redirect($this->generateUrl('secure_home'));
	
      }
    }
        
    return array('form' => $form->createView(),);
    
  }
  

}
