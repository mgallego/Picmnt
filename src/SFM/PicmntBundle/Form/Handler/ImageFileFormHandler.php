<?php

namespace SFM\PicmntBundle\Form\Handler;

use SFM\PicmntBundle\Form\Handler\AbstractFormHandler;
use Symfony\Component\Form\FormInterface;
use SFM\PicmntBundle\Model\Manager\ImageFileManager;
use Symfony\Component\HttpFoundation\Request;
use SFM\PicmntBundle\Entity\User;

class ImageFileFormHandler extends AbstractFormHandler
{

    /**
     * @var \Symfony\Component\Form\FormInterface $form
     */
    protected $form;

    /**
     * @var array $params
     */
    protected $params;

    /**
     * @var \SFM\PicmntBundle\Entity\User
     */
    protected $user;
    
    /**
     * @var \SFM\PicmntBundle\Model\Manager\ImageFileManager
     */
    protected $imageFileManager;

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param array                                 $params
     * @param \Doctrine\ORM\EntityManager           $em
     */
    public function __construct(FormInterface $form, Request $params, User $user, ImageFileManager $imageFileManager)
    {
        $this->form = $form;
        $this->params = $params;
        $this->imageFileManager = $imageFileManager;
        $this->user = $user;
    }

    /**
     * Processes the form and updates the Profile data
     *
     * @return bool
     */
    public function process()
    {
        $this->form->handleRequest($this->params);

        if (!$this->form->isValid()) {
            return false;
        }



        $imageUrl = $this->imageFileManager->getUrl(
            $this->form->getData()->dataFile,
            $this->user->getId() . '_' . date("ymdHis") . '_' . rand(1, 9999)
        );

        
        return true;
    }
}