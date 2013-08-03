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
        $thumbailManager = $this->get('mgp.image.thumbnail_manager');

        return $this->render(
            'MGPImageBundle:Image:thumbs.html.twig',
            ['images' => $thumbailManager->getThumbnails('all', 'popular'),
                'category' => 'all',
                'option' => 'popular',
                'show_categories' => false
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
        try {
            return $this->render('MGPMainBundle:Static:'.$page.'.html.twig');
        } catch (\InvalidArgumentException $e) {
            throw $this->createNotFoundException('The page does not exist');
        }
    }
}
