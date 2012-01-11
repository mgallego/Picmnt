<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

//Entities
use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\ImageComment;

use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{

  public function commentAction($idImage)
  {

    $image = new Image();

    $imageComment = new ImageComment();

    $em = $this->get('doctrine')->getEntityManager();     
    
    $image = $em->find('SFMPicmntBundle:Image',$idImage);

    $form = $this->get('form.factory')
      ->createBuilder('form', $imageComment)
      ->add('comment', 'text')
      ->getForm();

    $request = $this->get('request');
      
    if ($request->getMethod() == 'POST'){

      $form->bindRequest($request);
     
      if ($form->isValid()) {

	print($imageComment->getComment());

	$imageComment->setImage($image);
	$imageComment->setUser($this->container->get('security.context')->getToken()->getUser());

	$em->persist($imageComment);
	$em->flush();

	
	//	return $this->redirect($this->generateUrl('img_show').'/'.);
	print_r($request);

	return new Response('<html><head></head><body>Comments</body></html>');	
	
	}

    }
        return new Response(print('hola'));	


  }

}
