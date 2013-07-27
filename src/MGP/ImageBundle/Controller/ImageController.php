<?php

namespace MGP\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MGP\ImageBundle\Form\Type\ImageFormType;
use MGP\ImageBundle\Form\Handler\ImageFormHandler;
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
        $form = $this->createForm(new ImageFormType(), $image);

        if ($request->getMethod() == 'POST') {

            $formHandler = new ImageFormHandler(
                $form,
                $request,
                $this->getDoctrine()->getManager(),
                $image,
                $this->getUser()
            );
            
            if (!$formHandler->process()) {
                throw new \Exception($formHandler->showFormErrors());
            }
        }

        return $this->render('MGPImageBundle:Image:upload.html.twig', array('form' => $form->createView()));
    }
}
