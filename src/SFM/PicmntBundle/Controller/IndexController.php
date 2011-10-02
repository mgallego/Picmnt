<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Knplabs\Bundle\MenuBundle\MenuItem;



class IndexController extends Controller
{


    /**
    * @Route("/", name="home")
    * @Template()
    */
    public function indexAction()
    {
      

      if ($this->get('security.context')->isGranted('ROLE_USER')){

	return $this->redirect($this->generateUrl('secure_home'));
	
      }
      else{
	
	return array();

      }
       
    }


    /**
     * @Route("/p", name="secure_home")
     * @Template()
     */
    public function indexSecureAction()
    {
      return $this->redirect($this->generateUrl('img_show', Array("option"=>"random")));
      //return $this->redirect($this->generateUrl('home'));

    }


    /**
     * @Route("/lang/{_locale}", name="lang")
     */
    public function langAction()
    {
	return $this->redirect($this->generateUrl('home'));
    }


}
