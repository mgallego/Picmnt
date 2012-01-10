<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SFM\PicmntBundle\Repositories\ImageUp;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\User;
use SFM\PicmntBundle\Entity\UserVote;
use SFM\PicmntBundle\Entity\ImageComment;
use FOS\UserBundle\Entity\UserManager;

use SFM\PicmntBundle\Util\ImageUtil;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
  
  /**
   * @Route("/img/upload", name="img_upload")
   * @Template()
   */
  public function uploadAction()
  {
    
    $user = $this->container->get('security.context')->getToken()->getUser();

    $image = new Image();
    
    $imageUp = new ImageUp();
            
    $form = $this->get('form.factory')
      ->createBuilder('form', $imageUp)
      ->add('dataFile', 'file')
      ->getForm();
    

    if ($this->get('request')->getMethod() == 'POST'){

      $form->bindRequest( $this->get('request') );
       

      if ($form->isValid()) {

	$uploadedFile = $form['dataFile']->getData();

	if ($uploadedFile->getMimeType() == 'image/png' ){
	  $extension = '.png';
	}
	else{
	  $extension = '.jpg';
	}
		

	$newFileName = $user->getId().'_'.date("ymdHis").'_'.rand(1,9999).$extension;
	
	$uploadedFile->move(
	  $_SERVER['DOCUMENT_ROOT']."/uploads",
	  $newFileName );

	$imageUtil = new ImageUtil();

	$imageUtil->resizeImage('uploads/'.$newFileName, 800);

	$image->setUrl($newFileName);
	$image->setVotes(0);

	$image->setUser($user);

	$em = $this->get('doctrine')->getEntityManager();     
   	
	$em->persist($image);
	$em->flush();
	
	return $this->redirect($this->generateUrl('img_edit', array("id_image" => $image->getIdImage())));

      }
     
    }
        
    return array('form' => $form->createView(),);
    
  }


  /**
   * @Route("/img/edit/{id_image}", name="img_edit")
   * @Template()
   */
  public function editImageAction($id_image){

    $image = new Image();

    $em = $this->get('doctrine')->getEntityManager();     
    
    $image = $em->find('SFMPicmntBundle:Image',$id_image);

    $user = $this->container->get('security.context')->getToken()->getUser();

    if ($user->getId() != $image->getUser()->getId()) { //diferent user
      //show an error twig TODO
    }
    else{

      $form = $this->get('form.factory')
	->createBuilder('form', $image)
	->add('title', 'text')
	->add('description','textarea')
	->add('category','text')
	->add('tags','text')
	->getForm();

      $request = $this->get('request');
      
   
      if ($request->getMethod() == 'POST'){
	$form->bindRequest($request);
      

	if ($form->isValid()) {

	  print($image->getidImage());
	  print($image->getTitle());
	  print($image->getDescription());

	  $em->persist($image);
	  $em->flush();
	
	  return $this->redirect($this->generateUrl('img_show', array("option"=>"random", "idImage"=>$image->getIdImage()) ));

	}
	else
	  {

	    return array("image_url" => 'uploads/'.$image->getUrl(), 'form' => $form->createView(), 'image'=>$image);
	  }
      }

      return array("image_url" => 'uploads/'.$image->getUrl(), 'form' => $form->createView(), 'image'=>$image);
    }
  }


  private function getRandomImage()
  {

    $em = $this->get('doctrine')->getEntityManager();
        	
    $images = $em->getRepository('SFMPicmntBundle:Image')->getRandom();

    if (!$images){
	$e = $this->get('translator')->trans('There are no pictures in the database');
	throw $this->createNotFoundException($e);
    }
	    
          
    $image = $images[0];

    return $image;
    
  }
 


  //delete this function when finish the image show action 
  /**
   * @Route("/img/showTemp/{selection}", name="img_showTemp")
   * //@Template()
   */
  public function getImageTempAction($selection){

    $userVote = new UserVote();

    $em = $this->get('doctrine')->getEntityManager();
    
    //$em = $this->get('doctrine.orm.entity_manager');
    

    if ($selection == 'last') {
      $dql = "SELECT a FROM SFMPicmntBundle:Image a order by a.idImage desc";
    }

    $query = $em->createQuery($dql);

    $adapter = $this->get('knplabs_paginator.adapter');
    $adapter->setQuery($query);
    $adapter->setDistinct(true);
    

    $paginator = new \Zend\Paginator\Paginator($adapter);
    $paginator->setCurrentPageNumber($this->get('request')->query->get('page', 1));
    $paginator->setItemCountPerPage(1);
    $paginator->setPageRange(1);

    $items = $paginator->getCurrentItems();

    $image = new Image();

    //return the current object of the paginator
    $image = $items[0];
    
    //parameters for the Javascript votef button in the layout
    $parameters = Array("idImage"=>$image->getIdImage(), "voted"=>$this->hasVoted($image->getIdImage())
		  , "page"=>$paginator->getCurrentPageNumber(), "selection"=>$selection);

    $imageComment = new ImageComment();

    //comments form
    $formComment = $this->get('form.factory')
      ->createBuilder('form', $imageComment)
      ->add('comment', 'text')
      ->getForm();

    //test
    $imageNext = $em->getRepository('SFMPicmntBundle:Image')->findNext($image->getIdImage(),'p.idImage DESC');
    
    print($imageNext[0]->getIdImage(). ' actual '. $image->getIdImage());
    

    return array("paginator"=>$paginator, "parameters"=>$parameters, 
      "comments"=>$image->getImageComments(), "formComment"=>$formComment->createView());
  }



  /**
   * @Route("/img/{option}/{idImage}", defaults={"idImage"="0"}, name="img_show")
   * @Template()
   */
  public function showImageAction($option, $idImage = 0){
    
    $em = $this->get('doctrine')->getEntityManager();
    $paginator = Array();

    if ( $option == 'last' ) {

      if (!$image = $em->find('SFMPicmntBundle:Image',$idImage)){

	$images = $em->getRepository('SFMPicmntBundle:Image')->findFirst('p.idImage DESC');
	$image = $images[0];

      }

      $paginator = $this->getPaginator($option, $image->getIdImage());

    }
    else if ( $option = 'random' ){

      $image = $this->getRandomImage();

    }
      
    return Array("image"=>$image, "paginator"=>$paginator);

  }


  private function getPaginator($option, $idImage){
    
    return Array('imgNext'=>$this->getNext($option, $idImage), 
      'imgPrevious'=>$this->getPrevious($option, $idImage) );

  }


  private function getNext($orderOption, $idImage){

    if ($orderOption == 'last'){

      $em = $this->get('doctrine')->getEntityManager();
    
      if ( ! $images = $em->getRepository('SFMPicmntBundle:Image')->findNext($idImage, 'p.idImage')){

	$images = $em->getRepository('SFMPicmntBundle:Image')->findFirst('p.idImage DESC');    

      }

    }

    $image = $images[0];

    return $image->getIdImage();

  }

  private function getPrevious($orderOption, $idImage){

    $em = $this->get('doctrine')->getEntityManager();

    if ( $orderOption == 'last' ){
      
      if ( ! $images = $em->getRepository('SFMPicmntBundle:Image')->findPrevious($idImage, 'p.idImage DESC')){

	$images = $em->getRepository('SFMPicmntBundle:Image')->findFirst('p.idImage DESC');    

      }
     
    }

    $image = $images[0];

    return $image->getIdImage();

  }

    
  public function hasVoted($idImage){
    
    $user = $this->container->get('security.context')->getToken()->getUser();

    $repository = $this->get('doctrine')
      ->getEntityManager()
      ->getRepository('SFMPicmntBundle:UserVote');

    $query = $repository->createQueryBuilder('uv')
      ->where('uv.userId = :userId AND uv.idImage = :idImage')
      ->setParameters(array('userId'=>$user->getId(), 'idImage'=>$idImage))
      ->getQuery();

    $userVote = $query->getResult();
    
    
    if (!$userVote) { 
      return 0;
    }
    else{
      return 1;
    }

  }

  /**
   * @Route("/img/vote/{idImage}", name="img_vote")
   */
  public function voteAction($idImage){

    if ($this->hasVoted($idImage) == 0){

      $em = $this->get('doctrine')->getEntityManager();
      
      $image = $em->find('SFMPicmntBundle:Image',$idImage);
      
      $image->sumVotes();
      
      $user = $this->container->get('security.context')->getToken()->getUser();
      
      $image->addUserVotes($user);
    
      $em->persist($image);
      $em->flush();
      
    }    

  }

}
