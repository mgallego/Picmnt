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
    public function showThubsAction(Request $request, $option)
    {
        $category = !$request->get('cat')? 'all':  $request->get('cat');
        $thumbailManager = $this->get('mgp.image.thumbnail_manager');

        return $this->render(
            'MGPImageBundle:Image:thumbs.html.twig',
            ['images' => $thumbailManager->getThumbnails($category, $option),
                'category' => $category,
                'option' => $option,
                'show_categories' => true
                ]
        );
    }


    /**
     * Random Image
     *
     * @Route ("/random", name="random_image")     
     */
    public function randomImageAction(Request $request)
    {
        $category = !$request->get('cat')? 'all':  $request->get('cat');
        $em = $this->getDoctrine()->getManager();
        return $this->render(
            'MGPImageBundle:Image:view.html.twig',
            ['image'
                => $em->getRepository('MGPImageBundle:Image')->getRandom($category),
                'title_as_link' => true]
        );
    }
}
