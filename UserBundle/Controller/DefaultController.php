<?php

namespace SFM\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SFMUserBundle:Default:index.html.twig');
    }
}
