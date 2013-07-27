<?php

namespace MGP\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MGP\ImageBundle\Form\Type\ImageFormType;
use SFM\PicmntBundle\Form\Handler\ImageFileFormHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $form = $this->createForm(new ImageFormType());

        if ($request->getMethod() == 'POST') {

        }

        return $this->render('MGPImageBundle:Image:upload.html.twig', array('form' => $form->createView()));
    }
}