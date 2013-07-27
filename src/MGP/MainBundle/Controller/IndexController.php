<?php

namespace MGP\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Index controller
 *
 * @author Moises Gallego <moisesgallego@gmail.com>
 */
class IndexController extends Controller
{
    /**
     * Index Action
     *
     * @Route ("/", name="home")
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine')->getManager();

        $imagesPerPage = $this->container->getParameter('images_per_page');

        //show thumbs order by popularity
        $images = $em->getRepository('MGPImageBundle:Image')
            ->findByCategoryAndOrder(
                'all',
                'popularity',
                null,
                $imagesPerPage
            );

        return $this->render(
            'MGPImageBundle:Image:thumbs.html.twig',
            ['images' => $images,
                'category' => 'all',
                'option' => 'popular'
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
        return $this->render('MGPMainBundle:Static:'.$page.'.html.twig');
    }
}
