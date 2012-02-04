<?php

namespace SFM\PicmntBundle\Repositories;

use Symfony\Component\Validator\Constraints as Assert;
use SFM\PicmntBundle\Entity\Image;

class ImageUp
{
 
  /**
   * @Assert\Image(maxSize = "300k", mimeTypes = {
   *   "image/jpeg",
   *   "image/png"
   * })
   */
  public $dataFile;

 


 }

