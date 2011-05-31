<?php

namespace SFM\PicmntBundle\Repositories;

use Symfony\Component\Validator\Constraints as Assert;

class ImageUp
{
 
  /**
   * @Assert\File(maxSize = "1M", mimeTypes = {
   *   "image/jpg",
   *   "image/png"
   * })
   */
  public $dataFile;


 }

