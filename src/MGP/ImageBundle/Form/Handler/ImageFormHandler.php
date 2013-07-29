<?php

namespace MGP\ImageBundle\Form\Handler;

use MGP\MainBundle\Form\Handler\AbstractFormHandler;
use Symfony\Component\HttpFoundation\Request;
use MGP\ImageBundle\Entity\Image;
use MGP\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;

class ImageFormHandler extends AbstractFormHandler
{

    /**
    * @var EntityManager
    */
    protected $em;

    /**
    * @var Request
    */
    protected $request;

    /**
    * @var Image
    */
    protected $image;

    /**
    * @var User
    */
    protected $user;

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var String
     */
    protected $uploadDir;

    public function __construct(Form $form, Request $request, EntityManager $em, Image $image, User $user, $uploadDir)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
        $this->image = $image;
        $this->user = $user;
        $this->uploadDir = $uploadDir;
    }

    /**
    * Process the form
    *
    * @return boolean
    */
    public function process()
    {
        $this->form->handleRequest($this->request);

        if (!$this->form->isValid()) {
            return false;
        }
        $this->image->setUser($this->user);
        $this->image->upload($this->uploadDir);
        
        $this->em->persist($this->image);
        $this->em->flush();

        return true;
    }
}
