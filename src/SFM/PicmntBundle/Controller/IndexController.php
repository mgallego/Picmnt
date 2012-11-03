<?php
namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SFM\PicmntBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{

    public function indexAction(Request $request)
    {
        if ($this->get('security.context')->isGranted('ROLE_USER')){
            $response = $this->redirect($this->generateUrl('img_show', Array("option"=>"recents", "category"=>'all')));
        }else{
            $em = $this->get('doctrine')->getEntityManager();
            $lastImages = $em->getRepository('SFMPicmntBundle:Image')->getLastImages(10);
            $mostCommentImages = $em->getRepository('SFMPicmntBundle:Image')->getMostComment(10);
            $responseData = array('lastImages'=>$lastImages, 'mostComments'=>$mostCommentImages);
            $response = $this->render('SFMPicmntBundle:Index:index.html.twig', $responseData);
            $response->setPublic();
        }
        return $response;
    }

    public function staticAction($page)
    {
        return $this->render('SFMPicmntBundle:Static:'.$page.'.html.twig');
    }
}
