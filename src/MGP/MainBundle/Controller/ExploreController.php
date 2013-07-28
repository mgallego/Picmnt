<?php

namespace MGP\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ExploreController extends Controller
{

    /**
     * Show thumbnails
     *
     * @Route ("/{option}", name="show_thumbnails", options={"expose"=true},
     * requirements={"option" = "new|popular"})     
     */
    public function showThubsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $imagesPerPage = $this->container->getParameter('images_per_page');

        $category = !$request->get('cat')? 'all':  $request->get('cat');

        //show thumbs order by popularity
        $images = $em->getRepository('MGPImageBundle:Image')
            ->findByCategoryAndOrder(
                $category,
                'popularity',
                null,
                $imagesPerPage
            );

        return $this->render(
            'MGPImageBundle:Image:thumbs.html.twig',
            ['images' => $images,
                'category' => $category,
                'option' => 'popular',
                'show_categories' => true
                ]
        );
    }
}