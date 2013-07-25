<?php

namespace SFM\PicmntBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ImageFileMOdel
{
 
    /**
     * @Assert\File(maxSize = "10M", mimeTypes = {
     *   "image/jpeg",
     *   "image/png"
     * })
     */
    public $dataFile;
}
