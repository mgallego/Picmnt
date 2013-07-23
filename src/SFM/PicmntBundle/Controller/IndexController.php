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

        $em = $this->get('doctrine')->getManager();
        $paginator = [];

        $imagesPerPage = $this->container->getParameter('images_per_page');
        $paginator = $this->get('ideup.simple_paginator');
        $paginator->setItemsPerPage($imagesPerPage);

        $images = $em->getRepository('SFMPicmntBundle:Image')
            ->findByCategoryAndOrder($category, 'popularity',  null, $imagesPerPage);

        $loadMore = true;
        if (count($images) < $imagesPerPage) {
            $loadMore = false;
        }
        
        return $this->render(
            'SFMPicmntBundle:Image:recents.html.twig',
            ['images' => $images,
                'category' => $category,
                'option' => "popular",
                'loadMore' => $loadMore
                ]
        );

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
