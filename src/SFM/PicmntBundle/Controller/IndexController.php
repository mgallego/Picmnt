<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
      if ($this->get('security.context')->isGranted('ROLE_USER')){
	return $this->redirect($this->generateUrl('secure_home'));
      }
      else{
	return $this->render('SFMPicmntBundle:Index:index.html.twig');
      }
    }

    public function indexSecureAction()
    {
      return $this->redirect($this->generateUrl('img_show', Array("option"=>"random")));
    }

    public function langAction()
    {
	return $this->redirect($this->generateUrl('home'));
    }

}
