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

    /**
     * View Image
     *
     * @Route ("/view/{slug}", name="img_view")     
     */
    public function viewImageAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render(
            'MGPImageBundle:Image:view.html.twig',
            ['image'
                => $em->getRepository('MGPImageBundle:Image')->findOneBySlug($slug)]
        );
    }

    /**
     * Edit an Image
     *
     * @Route ("/img/edit/{id}", name="img_edit")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('MGPImageBundle:Image')->findOneById($id);

        if ($this->getUser()->getId() !== $image->getUser()->getId()) {
            return $this->redirect($this->generateUrl('home'));
        }

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
            return $this->redirect($this->generateUrl('img_view', ["slug" => $image->getSlug()]));
        }

        return $this->render(
            'MGPImageBundle:Image:edit.html.twig',
            ['form' => $form->createView(),
                'image' => $image]
        );
    }
}
