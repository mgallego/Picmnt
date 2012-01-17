<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SFM\PicmntBundle\Repositories\ImageUp;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\User;

use SFM\PicmntBundle\Util\ImageUtil;
use SFM\PicmntBundle\Form\ImageType;
use SFM\PicmntBundle\Form\ImageUpType;

class ImageController extends Controller
{
  
    public function uploadAction()
    {
    
	$user = $this->container->get('security.context')->getToken()->getUser();
	$image = new Image();
	$imageUp = new ImageUp();
            
	$form = $this->createForm(new ImageUpType(), $imageUp);

	if ($this->get('request')->getMethod() == 'POST'){

	    $form->bindRequest( $this->get('request') );

	    if ($form->isValid()) {

		$uploadedFile = $form['dataFile']->getData();
		$imageUtil = new ImageUtil();
		$extension = $imageUtil->getExtension($uploadedFile->getMimeType());
		$newFileName = $user->getId().'_'.date("ymdHis").'_'.rand(1,9999).$extension;
	
		$uploadedFile->move(
		    $_SERVER['DOCUMENT_ROOT']."/uploads",
		    $newFileName );

		$imageUtil->resizeImage('uploads/'.$newFileName, 800);

		$image->setUrl($newFileName);
		$image->setVotes(0);
		$image->setUser($user);
		$image->setTitle($newFileName);
		$image->setSlug($this->container->get('picmnt.utils')->getSlug($newFileName, 0, $user->getId()));
		$image->setPubDate(new \DateTime('today'));

		$em = $this->get('doctrine')->getEntityManager();     
		$em->persist($image);
		$em->flush();

		return $this->redirect($this->generateUrl('img_edit', array("id_image" => $image->getIdImage())));
	    }
	}
	return $this->render('SFMPicmntBundle:Image:upload.html.twig', array('form' => $form->createView()));
    }




    public function editAction($id_image){
	$image = new Image();
	$em = $this->get('doctrine')->getEntityManager();     
	$image = $em->find('SFMPicmntBundle:Image',$id_image);

	$user = $this->container->get('security.context')->getToken()->getUser();

	if ($user->getId() != $image->getUser()->getId()) { 
	    return $this->redirect($this->generateUrl('img_show', array("option"=>"show", "idImage"=>$id_image, "category"=>'all') ));
	}
	else{
	    $form = $this->createForm(new ImageType(), $image);
	    $request = $this->get('request');
      
	    if ($request->getMethod() == 'POST'){
		$form->bindRequest($request);

		if ($form->isValid()) {
		    $image->setSlug($this->container->get('picmnt.utils')->getSlug($image->getTitle(), $image->getIdImage(), $user->getId()));
		    $em->persist($image);
		    $em->flush();
	
		    return $this->redirect($this->generateUrl('img_view', array("user"=>$image->getUser()->getUsername(), "slug"=>$image->getSlug()) ));
		}
		else{
		    return $this->render('SFMPicmntBundle:Image:editImage.html.twig', array("image_url" => 'uploads/'.$image->getUrl(), 'form' => $form->createView(), 'image'=>$image));
		}
	    }
	    return $this->render('SFMPicmntBundle:Image:editImage.html.twig', array("image_url" => 'uploads/'.$image->getUrl(), 'form' => $form->createView(), 'image'=>$image));
	}
    }


    

    private function getRandomImage($category){
	$em = $this->get('doctrine')->getEntityManager();
	$image = $em->getRepository('SFMPicmntBundle:Image')->getRandom($category);

	if (!$image){
	    $e = $this->get('translator')->trans('There are no pictures in the database');
	    throw $this->createNotFoundException($e);
	}
          
	return $image[0];
    }
 

    public function showAction($option, $idImage = 0, $category = 'all'){
	
	$em = $this->get('doctrine')->getEntityManager();
	$paginator = Array();

	if ( $option == 'last' ) {

	    if (!$image = $em->find('SFMPicmntBundle:Image',$idImage)){
		$images = $em->getRepository('SFMPicmntBundle:Image')->findFirst('p.idImage DESC', $category);
		$image = $images[0];
	    }

	    $paginator = $this->getPaginator($option, $image->getIdImage(), $category);
	}
	else if ( $option == 'random' ){
	    $image = $this->getRandomImage($category);
	}
	else if ( $option == 'show' ){
	  $image = $em->find('SFMPicmntBundle:Image',$idImage);
	}

	return $this->render('SFMPicmntBundle:Image:showImage.html.twig', array("image"=>$image, "paginator"=>$paginator));
    }




    private function getPaginator($option, $idImage, $category = 'all'){
    
	return Array('imgNext'=>$this->getNext($option, $idImage, $category), 
	    'imgPrevious'=>$this->getPrevious($option, $idImage, $category) );

    }


    private function getNext($orderOption, $idImage, $category){

	if ($orderOption == 'last'){

	    $em = $this->get('doctrine')->getEntityManager();
    
	    if ( ! $images = $em->getRepository('SFMPicmntBundle:Image')->findNext($idImage, 'p.idImage', $category)){

		$images = $em->getRepository('SFMPicmntBundle:Image')->findFirst('p.idImage DESC', $category);    

	    }

	}

	$image = $images[0];

	return $image->getIdImage();

    }


    private function getPrevious($orderOption, $idImage, $category){

	$em = $this->get('doctrine')->getEntityManager();

	if ( $orderOption == 'last' ){
      
	    if ( ! $images = $em->getRepository('SFMPicmntBundle:Image')->findPrevious($idImage, 'p.idImage DESC', $category)){

		$images = $em->getRepository('SFMPicmntBundle:Image')->findFirst('p.idImage DESC', $category);    

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

    public function viewAction($user, $slug){
	$em = $this->get('doctrine')->getEntityManager();
	$image = $em->getRepository('SFMPicmntBundle:Image')->getByUserSlug($user, $slug);

	if (!$image){
	  $e = $this->get('translator')->trans('Picture Not Found');
	    throw $this->createNotFoundException($e);
	}
          
	return $this->render('SFMPicmntBundle:Image:viewImage.html.twig', array("image"=>$image[0]));
    }

}
