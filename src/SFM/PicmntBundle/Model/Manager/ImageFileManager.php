<?php

namespace SFM\PicmntBundle\Model\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageFileManager
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var array
     */
    protected $imageFileConfig;

    /**
     * @param \Doctrine\ORM\EntityManager           $em
     */
    public function __construct(EntityManager $em, array $imageFileConfig)
    {
        $this->em = $em;
        $this->imageFileConfig = $imageFileConfig;
    }

    public function getUrl(UploadedFile $uploadedFile, $newFileName)
    {
        return $this->saveImageInDisk($uploadedFile, $newFileName);
    }

    private function saveImageInDisk($uploadedFile, $newFileName)
    {
        $uploadedFile->move(
            $_SERVER['DOCUMENT_ROOT'].'/'.$this->imageFileConfig['upload_path'],
            $newFileName
        );

        return $newFileName;
    }
}