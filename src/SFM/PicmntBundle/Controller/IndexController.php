<?php
namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SFM\PicmntBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Session;

class IndexController extends Controller
{

    public function indexAction()
    {
      $locale = $this->get('session');
      $request = $this->get('request');

//      $lang = substr($request->server->get('HTTP_ACCEPT_LANGUAGE'),0,2);

//      $request->setLocale($lang);

      if ($this->get('security.context')->isGranted('ROLE_USER')){
	return $this->redirect($this->generateUrl('secure_home'));
      }
      else{
	  
	  $em = $this->get('doctrine')->getEntityManager();

	  $lastImages = $em->getRepository('SFMPicmntBundle:Image')->getLastImages(10);

	  $mostCommentImages = $em->getRepository('SFMPicmntBundle:Image')->getMostComment(10);

	  //	  print (\Doctrine\Common\Util\Debug::dump($mostCommentImages));

	  return $this->render('SFMPicmntBundle:Index:index.html.twig', array('lastImages'=>$lastImages, 'mostComments'=>$mostCommentImages));
      }
    }

    public function indexSecureAction()
    {
	return $this->redirect($this->generateUrl('img_show', Array("option"=>"random", "category"=>'all')));
    }

    public function langAction()
    {
	return $this->redirect($this->generateUrl('home'));
    }
    
    public function staticAction($page)
    {
      return $this->render('SFMPicmntBundle:Static:'.$page.'.html.twig');
    }

}
