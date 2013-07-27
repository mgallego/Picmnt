<?php

namespace MGP\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MGP\ImageBundle\Form\Type\ImageFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use MGP\ImageBundle\Entity\Image;

/**
 * Image Controller
 *
 * @author Moises Gallego <moisesgallego@gmail.com>
 */
class ImageController extends Controller
{

    /**
     * Upload an Image
     *
     * @Route ("/img/upload", name="img_upload")
     */
    public function uploadAction(Request $request)
    {
        $image = new Image();
        $form = $this->createForm(new ImageFormType(),$image);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $image->setUser($this->getUser());
                $image->upload();

                $em->persist($image);
                $em->flush();
            }                
        }
        return $this->render('MGPImageBundle:Image:upload.html.twig', array('form' => $form->createView()));
    }
}