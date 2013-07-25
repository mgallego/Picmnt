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
     * @param \Doctrine\ORM\EntityManager           $em
     */
    public function __construct(EntityManager $em, array $config)
    {
        $this->em = $em;
        echo '<br/> Doctrine Jean Claude var_dump in ImageFileManager Line 21';
        echo '<br/><pre>';
        \Doctrine\Common\Util\Debug::dump($config);
        echo '</pre>';
        die;
    }

    public function getUrl(UploadedFile $file)
    {
        return 'Path';







        $imageUtil = $this->container->get('image.utils');
        $imageDefaults = $this->container->getParameter('image_defaults');
        $uploadedFile = $form['dataFile']->getData();
        $extension = $imageUtil->getExtension($uploadedFile->getMimeType());
        $newFileName = $user->getId().'_'.date("ymdHis").'_'.rand(1, 9999).$extension;
        
        $uploadedFile->move(
            $_SERVER['DOCUMENT_ROOT'].$this->container->getParameter('upload_path'),
            $newFileName
        );
        
    }
}