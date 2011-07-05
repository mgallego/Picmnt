<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SFM\PicmntBundle\Repositories\ImageUp;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\HttpFoundation\File\UploadedFile;

//Entities
use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\User;
use SFM\PicmntBundle\Entity\UserVote;
use SFM\PicmntBundle\Entity\ImageComment;
use FOS\UserBundle\Entity\UserManager;


//Classes
use SFM\PicmntBundle\Util\ImageUtil;

use Symfony\Component\HttpFoundation\Response;


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
    
    //retrieving the user information 
    $user = $this->container->get('security.context')->getToken()->getUser();

    $image = new Image();
    
     //this object is use for the validators
     $imageUp = new ImageUp();
            
    //calling the form
    $form = $this->get('form.factory')
      ->createBuilder('form', $imageUp)
      ->add('dataFile', 'file')
      //add('FieldName', 'type')
      ->getForm();
    
    //retrieving the request
    $request = $this->get('request');
 
   
    if ($request->getMethod() == 'POST'){
      $form->bindRequest($request);
      

      if ($form->isValid()) {

	$files=$request->files->get($form->getName());

	$uploadedFile=$files["dataFile"]["file"]; //"dataFile" is the name on the field

	//once you have the uploadedFile object there is some sweet functions you can run
	$uploadedFile->getPath();//returns current (temporary) path
	$uploadedFile->getOriginalName();
	$uploadedFile->getMimeType();

	
	//rerieving the file extension
	if ($uploadedFile->getMimeType() == 'image/png' ){
	  $extension = '.png';
	}
	else{
	  $extension = '.jpg';
	}
	  

	//creating a new name for the file
	$newFileName = $user->getId().'_'.date("ymdHis").'_'.rand(1,9999).$extension;
	
	//and most important is move(),
	$uploadedFile->move(
	  $_SERVER['DOCUMENT_ROOT']."/uploads",
	  $newFileName );

	$imageUtil = new ImageUtil();

	//resize the image if is necesary
	$imageUtil->resizeImage('uploads/'.$newFileName, 800);

	//save the url of the image (name) into the database
	$image->setUrl($newFileName);
	$image->setVotes(0);

	//$user->addImages($image);

	$image->setUser($user);

	//persist in the database
	$em = $this->get('doctrine')->getEntityManager();     
   	
	$em->persist($image);
	$em->flush();

	//show the edit image page
	return $this->redirect($this->generateUrl('img_edit', array("id_image" => $user->getImage->getIdImage())));
	
      }
      else {

	//return the same form view
	return array('form' => $form->createView(),);

      }
    }
        
    //create the first form
    return array('form' => $form->createView(),);
    
  }


 
  /************************************************************************
   ************************ EDIT IMAGE  ACTION ***************************
   ************************************************************************
   ************** Edit an uploaded image ************** *******************
   ***********************************************************************/

  /**
   * @Route("/img/edit/{id_image}", name="img_edit")
   * @Template()
   */
  public function editImageAction($id_image){

    //retrieving the image info
    $image = new Image();

    $em = $this->get('doctrine')->getEntityManager();     
    
    $image = $em->find('SFMPicmntBundle:Image',$id_image);

    //retrieving the user information 
    $user = $this->container->get('security.context')->getToken()->getUser();

    //compare the actual user and the property of the image
    if ($user->getId() != $image->getUser()->getId()) { //diferent user
      //show an error twig
    }
    else{

      //calling the form
      $form = $this->get('form.factory')
	->createBuilder('form', $image)
	->add('title', 'text')
	->add('description','textarea')
	->add('category','text')
	->add('tags','text')
	//add('FieldName', 'type')
	->getForm();



      //retrieving the request
      $request = $this->get('request');
      
   
      if ($request->getMethod() == 'POST'){
	$form->bindRequest($request);
      

	if ($form->isValid()) {

	  print($image->getidImage());
	  print($image->getTitle());
	  print($image->getDescription());

	  $em->persist($image);
	  $em->flush();
	
	  return $this->redirect($this->generateUrl('img_random'));


	}
	else
	  {

	    return array("image_url" => 'uploads/'.$image->getUrl(), 'form' => $form->createView(), 'id_image'=>$id_image);
	  }
      }
      //show the image un the edit view
      return array("image_url" => 'uploads/'.$image->getUrl(), 'form' => $form->createView(), 'id_image'=>$id_image);
    }
  }



  /************************************************************************
   *******************  GET RANDOM IMAGE ACTION ***************************
   ************************************************************************
   ************** Reurn a random image ************************************
   ***********************************************************************/

 /**
   * @Route("/img/random", name="img_random")
   * @Template()
   */
  public function getRandomImageAction(){


    //preparing the sql statement
    $rsm = new ResultSetMapping;
    $rsm->addEntityResult('SFM\PicmntBundle\Entity\Image','i');
    $rsm->addFieldResult('i', 'idImage','idImage');
    $rsm->addFieldResult('i','url','url');
    $rsm->addFieldResult('i','title','title');
    $rsm->addFieldResult('i','description','description');

    $image = new Image();

    $em = $this->get('doctrine')->getEntityManager();

    //$query = $em->createQuery('SELECT i.url, \''.rand().'\' rand FROM SFM\PicmntBundle\Entity\Image i ORDER BY rand');

    $query = $em->createNativeQuery('SELECT url, id_image AS idImage, title, description FROM Image ORDER BY rand() limit 1', $rsm);
    
    $images = $query->getResult();

    //obtain the image
    $image = $images[0];

    //show the view with the image
    return array('image'=> 'uploads/'.$image->getUrl(),'title'=>$image->getTitle(),'description'=>$image->getDescription(), 'id_image'=>$image->getIdImage()  );

  }
 

 /**
   * @Route("/img/show/{selection}", name="img_show")
   * @Template()
   */
  public function getImageAction($selection){

    $userVote = new UserVote();

    $em = $this->get('doctrine')->getEntityManager();
    
    //$em = $this->get('doctrine.orm.entity_manager');
    

    if ($selection == 'last') {
      $dql = "SELECT a FROM SFMPicmntBundle:Image a order by a.idImage desc";
    }


    $query = $em->createQuery($dql);


    //preparing the sql statement
 
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
    
    //    print_r($this->redirect($this->generateUrl('comment'.'/184')));

    return array("paginator"=>$paginator, "parameters"=>$parameters, 
      "comments"=>$image->getImageComments(), "formComment"=>$formComment->createView());
  }


  
   /**
   * @Route("/img/show2/{selection}", defaults={"idImage"="0"}),
   * @Route("/img/show2/{selection}/{idImage}", name="img_show2")
   * //@Template()
   */
  public function getImage2Action($selection, $idImage = 0){

      //get the conection
      $em = $this->get('doctrine')->getEntityManager();
      
      $image = new Image();
      
      if ($selection == 'last')
      {
         
          if ($idImage == 0)
          {
             //get the last record 
             $images = $em->getRepository('SFMPicmntBundle:Image')->findFirst('p.idImage DESC');
             
             $image = $images[0];
             
           }
           else
           {
               $image = $em->find('SFMPicmntBundle:Image',$idImage);
               
               if (!$image)
               {
                   return new Response('<html><head></head><body>404 404 404</body></html>');	
               }

               
           }
          
      }
      
        print($image->getIdImage());
      
        return new Response('<html><head></head><body></body></html>');	
    
    }

  
  
  
  
  
  public function hasVoted($idImage){
    
    //load the current users data
    $user = $this->container->get('security.context')->getToken()->getUser();

    $repository = $this->get('doctrine')
      ->getEntityManager()
      ->getRepository('SFMPicmntBundle:UserVote');

    //query the votes of the user for this image
    $query = $repository->createQueryBuilder('uv')
      ->where('uv.userId = :userId AND uv.idImage = :idImage')
      ->setParameters(array('userId'=>$user->getId(), 'idImage'=>$idImage))
      ->getQuery();

    $userVote = $query->getResult();
    
    
    if (!$userVote) { //if the image has not voted
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
