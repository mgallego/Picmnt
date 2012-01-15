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

	$em->persist($imageComment);
	$em->flush();

    }
    return $this->redirect($this->generateUrl('_img_show', array("option" => 'show', "idImage" => $image->getIdImage())));
  }

}
