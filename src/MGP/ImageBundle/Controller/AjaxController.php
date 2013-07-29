<?php

namespace MGP\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ajax Controller
 *
 * @author Moises Gallego <moisesgallego@gmail.com>
 */
class AjaxController extends Controller
{

    /**
     * View an image
     *
     * @Route ("/ajax/images/get_more", name="ajax_img_get_more", options={"expose"=true})
     */
    public function getMoreImagesAction(Request $request)
    {
        $images = $this->get('mgp.image.thumbnail_manager')
            ->getMoreThumbs(
                $request,
                $this->container->get('liip_imagine.controller')
            );
        return new Response(json_encode($images));
    }
}
