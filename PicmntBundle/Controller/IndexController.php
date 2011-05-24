<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class IndexController extends Controller
{

  //Home page, only show the page
    /**
    * @Route("/", name="home")
    * @Template()
    */
    public function indexAction()
    {
      	return array();
    }

    //Secure home
    /**
     * @Route("/p", name="secure_home")
     * @Template()
     */
    public function indexSecureAction()
    {
      return array();
    }


    //Language Selector
    /**
     * @Route("/lang/{_locale}", name="lang")
     */
    public function langAction()
    {
	return $this->redirect($this->generateUrl('secure_home'));
    }


}
