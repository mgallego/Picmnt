<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\ImageComment;
use Symfony\Component\HttpFoundation\Response;
use SFM\PicmntBundle\Form\CommentType;

class CommentController extends Controller{



    /**
     * Publish a new comment in an image
     *
     */
    public function commentAction($idImage){
	$logger = $this->get('logger');
	$imageComment = new ImageComment();

	$em = $this->get('doctrine')->getManager();     
	$image = $em->find('SFMPicmntBundle:Image',$idImage);

	$request = $this->get('request');
    
	if ($request->getMethod() == 'POST'){
	
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
    
	$options = array("user"=>$image->getUser()->getUsername(), "slug"=>$image->getSlug());
	return $this->redirect($this->generateUrl('img_view', $options ));
    
    }




    /**
     * Delete a comment
     *
     */
    public function deleteAction($idComment){
	$em = $this->get('doctrine')->getManager();     
	$user = $this->container->get('security.context')->getToken()->getUser();
	$comment = $em->find('SFMPicmntBundle:ImageComment', $idComment);
    
	if (!$comment){
	    $e = $this->get('translator')->trans('There are no comments in the database');
	    throw $this->createNotFoundException($e);
	}

	if ($user->getId() != $comment->getUser()->getId()) { 
	    return $this->redirect($this->generateUrl('home'));
	}
	else{
	    $image = $comment->getImage();
      
	    $em->remove($comment);
	    $em->flush();
      
	    $options = array("user"=>$image->getUser()->getUsername(), "slug"=>$image->getSlug());
	    return $this->redirect($this->generateUrl('img_view', $options));
	}


    }
}
