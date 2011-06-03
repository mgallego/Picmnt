<?php

namespace SFM\PicmntBundle\Util;

class ImageUtil{

  //resize the images to 800px maximun
  public function resizeImage($imageFile){

    $width = 800;
    $height = 800;

    //retrieving the original image size
    list($widthOrig, $heightOrig) = getimagesize($imageFile);


    //if a side of the image as greater than 800px 
    if ($widthOrig > 800 or $heightOrig > 800){


      
      $ratioOrig = $widthOrig/$heightOrig;
      
      if ($width/$height > $ratioOrig) {
	$width = $height * $ratioOrig;
      }
      else{
	$height = $width / $ratioOrig;
      }
      
   

      //ceate the new image
      $image_p = imagecreatetruecolor($width, $height);

      if (exif_imagetype($imageFile) == 2){ //jpeg
	$image = imagecreatefromjpeg($imageFile);      
      }
      elseif (exif_imagetype($imageFile) == 3){ //PNG
	$image = imagecreatefrompng($imageFile);
      }
      
      //resampling the image
      imagecopyresampled($image_p,$image, 0,0,0,0,$width, $height, $widthOrig, $heightOrig);
      

      //save the image with the same name to rewrite it
      imagejpeg($image_p,$imageFile,100);

    }

  }




}

?>