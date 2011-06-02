<?php

namespace SFM\PicmntBundle\Util;

class ImageUtil{

  public function resizeImage($imageFile){

    $width = 800;
    $height = 800;

    list($widthOrig, $heightOrig) = getimagesize($imageFile);

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
    
    imagejpeg($image_p,$imageFile,100);


  }




}

?>