<?php

namespace MGP\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MGP\ImageBundle\Entity\Image;

/**
 * Image Controller
 *
 * @author Moises Gallego <moisesgallego@gmail.com>
 */
abstract class AbstractImageController extends Controller
{

    /**
     * Check Owner
     *
     * @param Image $image
     */
    protected function checkOwner(Image $image)
    {
        if ($this->getUser()->getId() !== $image->getUser()->getId()) {
            return $this->redirect($this->generateUrl('home'));
        }
    }

    /**
     * Get Image or 404
     *
     * @param array $query
     *
     * @return Image
     * @throws NotFoundException
     */
    protected function getImagerOr404(array $query)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('MGPImageBundle:Image')->findOneBy($query);

        if (!$image) {
            throw $this->createNotFoundException('The image does not exist');
        }
        return $image;
    }
}
