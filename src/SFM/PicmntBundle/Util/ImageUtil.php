<?php

namespace SFM\PicmntBundle\Util;

class ImageUtil{

  public function resizeImage($imageFile, $maxSize){
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
      
      imagejpeg($image_p,$imageFile,80);
    }
  }

  public function createImageSmall($imageFile, $imageFileDest, $maxSize){
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

      imagejpeg($image_p,$imageFileDest,40);
    }
  }


  public function getExtension($mimeType)
  {
      if ($mimeType= 'image/png' ){
	  return '.png';
      }
      return '.jpg';
  }
}

