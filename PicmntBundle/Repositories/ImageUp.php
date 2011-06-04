<?php

namespace SFM\PicmntBundle\Repositories;

use Symfony\Component\Validator\Constraints as Assert;
use SFM\PicmntBundle\Entity\Image;

class ImageUp //extends Image
{
 
  /**
   * @Assert\File(maxSize = "1M", mimeTypes = {
   *   "image/jpeg",
   *   "image/png"
   * })
   */
  public $dataFile;

 


 }

