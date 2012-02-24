<?php

namespace SFM\PicmntBundle\Repositories;

use Symfony\Component\Validator\Constraints as Assert;
use SFM\PicmntBundle\Entity\Image;

class ImageUp
{
 
  /**
   * @Assert\File(maxSize = "10M", mimeTypes = {
   *   "image/jpeg",
   *   "image/png"
   * })
   */
  public $dataFile;

 


 }

