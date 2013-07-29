<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SFM\PicmntBundle\Form\Type\ImageFileFormType;
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
     * Edit an image
     *
     * @Route ("/img/edit/{id_image}", name="img_edit")     
     */
    public function editAction($id_image){
        $em = $this->get('doctrine')->getManager();     
        $image = $em->find('SFMPicmntBundle:Image',$id_image);
        $user = $this->container->get('security.context')->getToken()->getUser();
        $oldSlug = $image->getSlug();
        $response = null;

        //Default response
        $form = $this->createForm(new ImageType(), $image);
        $imgUtilsConf = $this->container->getParameter('image_defaults');
        $options = array("image_url" => $imgUtilsConf['upload_path'].$image->getUrl(), 'form' => $form->createView(), 'image'=>$image);
        $response = $this->render('SFMPicmntBundle:Image:editImage.html.twig', $options);
    
        if ($this->getCurrentUserId() != $image->getUser()->getId()) { 
            $imageDefaults = $this->container->getParameter('image_defaults');
            $defaultCategory = $imageDefaults['category'];
            $options =array("option"=>"show", "idImage"=>$id_image, "category"=>$defaultCategory);
            $response = $this->redirect($this->generateUrl('img_show', $options));
        }
        else{
            $request = $this->get('request');
            if ($request->getMethod() == 'POST'){
                $form->handleRequest($request);
                if ($form->isValid()) {
                    if ($oldSlug === $image->getFirstSlug() && $image->getFirstTitle() !== $image->getTitle()){
                        $utils = $this->container->get('picmnt.utils');
                        $image->setSlug($utils->getSlug($image->getTitle(), $image->getIdImage(), $user->getId()));
                    }
                    $em->persist($image);
                    $em->flush();
          
                    $options = array("user"=>$image->getUser()->getUsername(), "slug"=>$image->getSlug());
                    $response = $this->redirect($this->generateUrl('img_view', $options )); 
                }
            }
        }
        return $response;
    }

    /**
     * Change the image status to delete 2
     *
     * @Route ("/img/delete/{idImage}", name="img_delete")     
     */
    public function deleteAction($idImage){
        $em = $this->get('doctrine')->getManager();     
        $image = $em->find('SFMPicmntBundle:Image', $idImage);
        $user = $this->container->get('security.context')->getToken()->getUser();

        if ($this->getCurrentUserId() != $image->getUser()->getId()) { 
            return $this->redirect($this->generateUrl('img_show', array("option"=>"show", "idImage"=>$idImage, "category"=>'all') ));
        }
    
        $image->setStatus(2);
        $em->persist($image);
        $em->flush();
    
        return $this->redirect($this->generateUrl('usr_profile', array("userName"=>$user->getUsername()) ));
    }
    
    /**
     * Show an Image
     *
     */
    public function showAction(Request $request, $option, $idImage = 0, $category = 'all'){
        if ($request->get('cat')) {
            $category = $request->get('cat');
        }

        $em = $this->get('doctrine')->getManager();
        $categories = $em->getRepository('SFMPicmntBundle:Category')->findAll();

        $paginator = [];

        $imagesPerPage = $this->container->getParameter('images_per_page');

        
        switch ($option) {
            case 'random':
                $image = $em->getRepository('SFMPicmntBundle:Image')->getRandom($category);
                break;
            case 'show':
                $image = $em->find('SFMPicmntBundle:Image',$idImage);
                break;
            case 'recents':
                $images = $em->getRepository('SFMPicmntBundle:Image')
                    ->findByCategoryAndOrder($category, 'idImage',  null, $imagesPerPage);
                break;
            case 'popular':
                $images = $em->getRepository('SFMPicmntBundle:Image')
                    ->findByCategoryAndOrder($category, 'popularity',  null, $imagesPerPage);
                break;

        }

        if ($option === 'recents' || $option === 'popular') {
            $loadMore = true;
            if (count($images) < $imagesPerPage) {
                $loadMore = false;
            }
            return $this->render(
                'SFMPicmntBundle:Image:recents.html.twig',
                ['option' => $option,
                    'category' => $category,
                    'images' => $images,
                    'loadMore' => $loadMore,
                        'categories' => $categories]
            );
        }
        return $this->render('SFMPicmntBundle:Image:viewImage.html.twig', ['image' => $image, 'paginator' => $paginator]);
    }


    /**
     * View an image
     *
     * @Route ("/view/{user}/{slug}", name="img_view")     
     */
    public function viewAction($user, $slug)
    {
        $em = $this->get('doctrine')->getManager();
        $image = $em->getRepository('SFMPicmntBundle:Image')->getByUserSlug($user, $slug);

        if (!$image) {
            $e = $this->get('translator')->trans('Picture Not Found');
            throw $this->createNotFoundException($e);
        }
    
        $user = $this->container->get('security.context')->getToken()->getUser();
    
        if ($this->getCurrentUserId() == $image[0]->getUser()->getId()){
            $this->deleteNotifications($image);
        }

        return $this->render('SFMPicmntBundle:Image:viewImage.html.twig', array("image"=>$image[0]));
    }

    /**
     * Delete a notification
     *
     */
    private function deleteNotifications($image){
        $em = $this->get('doctrine')->getManager();
        $comments = $em->getRepository('SFMPicmntBundle:ImageComment')->findByImage($image);
      
        foreach ($comments as $comment){
            $comment->setNotified(1);
            $comment->setEmailNotified(1);
            $em->persist($comment);
        }
        $em->flush();
    }
    
    /**
     * Get the current User ID
     *
     */
    private function getCurrentUserId(){
        $user =  $this->container->get('security.context')->getToken()->getUser();
        if ($this->get('security.context')->isGranted('ROLE_USER')){
            return $user->getId();}
      
        return 0;
    }
}
