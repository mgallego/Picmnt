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
    $logger = $this->get('logger');
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

      //if ($form->isValid()) {

	$imageComment->setComment($request->get('comment'));
	$imageComment->setImage($image);
	$imageComment->setUser($this->container->get('security.context')->getToken()->getUser());
	$imageComment->setBrightness($request->get('brightness'));
	$imageComment->setContrast($request->get('contrast'));
	$imageComment->setExposure($request->get('exposure'));
	$imageComment->setSaturation($request->get('saturation'));

	$user = $this->container->get('security.context')->getToken()->getUser();
	if ($user->getId() == $image->getUser()->getId()) {
	  $imageComment->setNotified(1);
	  $imageComment->setEmailNotified(1);
	}
	else{
	  $imageComment->setNotified(0);
	  $imageComment->setEmailNotified(0);
	}

	$em->persist($imageComment);
	$em->flush();

    }
    
    return $this->redirect($this->generateUrl('img_view', array("user"=>$image->getUser()->getUsername(), "slug"=>$image->getSlug()) ));
    
  }

  public function deleteAction($idComment){
    $em = $this->get('doctrine')->getEntityManager();     
    $user = $this->container->get('security.context')->getToken()->getUser();
    $comment = $em->find('SFMPicmntBundle:ImageComment', $idComment);
    
    if (!$comment){
      $e = $this->get('translator')->trans('There are no comments in the database');
      throw $this->createNotFoundException($e);
    }

    if ($user->getId() != $comment->getUser()->getId()) { 
      return $this->redirect($this->generateUrl('img_show', array("option"=>"show", "idImage"=>$idImage, "category"=>'all') ));
    }
    else{
      $image = $comment->getImage();
      
      $em->remove($comment);
      $em->flush();
      
      return $this->redirect($this->generateUrl('img_view', array("user"=>$image->getUser()->getUsername(), "slug"=>$image->getSlug()) ));
    }


  }
}
