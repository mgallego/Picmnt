<?php
namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SFM\PicmntBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $paginator = array();
        
        $paginator = $this->get('ideup.simple_paginator');
        $paginator->setItemsPerPage(1000);
        $images = $paginator->paginate($em->getRepository('SFMPicmntBundle:Image')->getRecentsDQL('all'))->getResult();

        return $this->render('SFMPicmntBundle:Image:recents.html.twig', array("images"=>$images));

    }

    public function staticAction($page)
    {
        return $this->render('SFMPicmntBundle:Static:'.$page.'.html.twig');
    }
}
