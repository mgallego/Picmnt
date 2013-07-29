<?php

namespace MGP\ImageBundle\Controller;

use MGP\ImageBundle\Form\Type\ImageFormType;
use MGP\ImageBundle\Form\Handler\ImageFormHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use MGP\ImageBundle\Entity\Image;
use MGP\ImageBundle\Controller\AbstractImageController;

/**
 * Image Controller
 *
 * @author Moises Gallego <moisesgallego@gmail.com>
 */
class ImageController extends AbstractImageController
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
                $this->getUser(),
                $this->container->getParameter('kernel.root_dir').'/../web/'
            );
            
            if (!$formHandler->process()) {
                throw new \Exception($formHandler->showFormErrors());
            }
            return $this->redirect($this->generateUrl('img_view', ["slug" => $image->getSlug()]));
        }
        
        return $this->render('MGPImageBundle:Image:upload.html.twig', array('form' => $form->createView()));
    }

    /**
     * View Image
     *
     * @Route ("/view/{slug}", name="img_view")     
     */
    public function viewImageAction($slug)
    {
        $image = $this->getImagerOr404(['slug' => $slug]);

        return $this->render(
            'MGPImageBundle:Image:view.html.twig',
            ['image'
                => $image]
        );
    }

    /**
     * Edit an Image
     *
     * @Route ("/img/edit/{id}", name="img_edit")
     */
    public function editAction(Request $request, $id)
    {
        $image = $this->getImagerOr404(['id' => $id]);

        $this->checkOwner($image);

        $form = $this->createForm(new ImageFormType(), $image);

        if ($request->getMethod() == 'POST') {

            $formHandler = new ImageFormHandler(
                $form,
                $request,
                $this->getDoctrine()->getManager(),
                $image,
                $this->getUser(),
                $this->container->getParameter('kernel.root_dir').'/../web/'
            );
            
            if (!$formHandler->process()) {
                throw new \Exception($formHandler->showFormErrors());
            }
            return $this->redirect($this->generateUrl('img_view', ["slug" => $image->getSlug()]));
        }

        return $this->render(
            'MGPImageBundle:Image:edit.html.twig',
            ['form' => $form->createView(),
                'image' => $image]
        );
    }

    /**
     * Change the image status to delete 2
     *
     * @Route ("/img/delete/{id}", name="img_delete")     
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $this->getImagerOr404(['id' => $id]);

        $this->checkOwner($image);

        $image->setStatus(2);
        $em->persist($image);
        $em->flush();
    
        return $this->redirect($this->generateUrl('show_thumbnails', ['option' => 'new']));
    }
}
