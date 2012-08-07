<?php

namespace SFM\PicmntBundle\Util;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContextInterface;

class ImageUtil{

    private $uploadPath;
    private $thumbsPath;
    protected $em;
    protected $securityContext;

    public function __construct(EntityManager $em, SecurityContextInterface $securityContext){
	$this->em = $em;
    }

    public function resizeImage($imageFile, $maxSize){
	$imageFile = $this->uploadPath.$imageFile;
	$width = $maxSize;
	$height = $maxSize;

	list($widthOrig, $heightOrig) = getimagesize($imageFile);

	if ($widthOrig > $maxSize or $heightOrig > $maxSize){

	    $ratioOrig = $widthOrig/$heightOrig;
      
	    if ($width/$height > $ratioOrig) {
		$width = $height * $ratioOrig;
	    }
	    else{
		$height = $width / $ratioOrig;
	    }

	    $image_p = imagecreatetruecolor($width, $height);

	    if (exif_imagetype($imageFile) == 2){ //jpeg
		$image = imagecreatefromjpeg($imageFile);      
	    }
	    elseif (exif_imagetype($imageFile) == 3){ //PNG
		$image = imagecreatefrompng($imageFile);
	    }
	    imagecopyresampled($image_p,$image, 0,0,0,0,$width, $height, $widthOrig, $heightOrig);
      
	    imagejpeg($image_p,$imageFile,90);
	}
    }



    public function createImageSmall($imageFile, $imageFileDest, $maxSize){
	$imageFile = $this->uploadPath.$imageFile;
	$imageFileDest = $this->thumbsPath.$imageFileDest;
	$width = $maxSize;
	$height = $maxSize;

	list($widthOrig, $heightOrig) = getimagesize($imageFile);

	if ($widthOrig > $maxSize or $heightOrig > $maxSize){

	    $ratioOrig = $widthOrig/$heightOrig;
      
	    if ($width/$height > $ratioOrig) {
		$width = $height * $ratioOrig;
	    }
	    else{
		$height = $width / $ratioOrig;
	    }

	    $image_p = imagecreatetruecolor($width, $height);

	    if (exif_imagetype($imageFile) == 2){ //jpeg
		$image = imagecreatefromjpeg($imageFile);      
	    }
	    elseif (exif_imagetype($imageFile) == 3){ //PNG
		$image = imagecreatefrompng($imageFile);
	    }

	    imagecopyresampled($image_p,$image, 0,0,0,0,$width, $height, $widthOrig, $heightOrig);

	    imagejpeg($image_p,$imageFileDest,60);
	}
    }


    public function getExtension($mimeType)
    {
	if ($mimeType= 'image/png' ){
	    return '.png';
	}
	return '.jpg';
    }



    public function setParameters($imageUtilsConfig){
	$this->uploadPath = $imageUtilsConfig['upload_path'];
	$this->thumbsPath = $imageUtilsConfig['thumbs_path'];
    }



    public function voteAction($idImage){

	if ($this->hasVoted($idImage) == 0){

	    $em = $this->em;
      
	    $image = $em->find('SFMPicmntBundle:Image',$idImage);
      
	    $image->sumVotes();
      
	    $user = $this->securityContext->getToken()->getUser();
      
	    $image->addUserVotes($user);
    
	    $em->persist($image);
	    $em->flush();
      
	}    

    }


}

