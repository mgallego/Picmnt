<?php
namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SFM\PicmntBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IndexController extends Controller
{

    /**
     * Index Action
     *
     * @Route ("/", name="home")
     */
    public function indexAction(Request $request)
    {
        $category = 'all';

        $em = $this->get('doctrine')->getEntityManager();
        $paginator = array();

        $imagesPerPage = $this->container->getParameter('images_per_page');
        $paginator = $this->get('ideup.simple_paginator');
        $paginator->setItemsPerPage($imagesPerPage);
        $images = $paginator->paginate($em->getRepository('SFMPicmntBundle:Image')->getRecentsDQL($category))->getResult();

        return $this->render('SFMPicmntBundle:Image:recents.html.twig', array("images"=>$images, "option" => "recents"));

    }

    /**
     * Static pages
     *
     * @Route ("/static/{page}", name="static_page")
     */
    public function staticAction($page)
    {
        return $this->render('SFMPicmntBundle:Static:'.$page.'.html.twig');
    }
}
