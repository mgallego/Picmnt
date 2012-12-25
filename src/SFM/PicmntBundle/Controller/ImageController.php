<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SFM\PicmntBundle\Repositories\ImageUp;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\User;
use SFM\PicmntBundle\Form\ImageType;
use SFM\PicmntBundle\Form\ImageUpType;

/**
 * Image Controller
 *
 * @author Moises Gallego <moisesgallego@gmail.com>
 */
class ImageController extends Controller
{

    /**
     * Upload an Image and set the defaults data
     *
     */
    public function uploadAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $image = new Image();
        $imageUp = new ImageUp();
        $em = $this->get('doctrine')->getEntityManager();
        $form = $this->createForm(new ImageUpType(), $imageUp);

        if ($this->get('request')->getMethod() == 'POST') {
            $form->bindRequest($this->get('request'));
            if ($form->isValid()) {
                $imageUtil = $this->container->get('image.utils');
                $imageDefaults = $this->container->getParameter('image_defaults');
                $uploadedFile = $form['dataFile']->getData();
                $extension = $imageUtil->getExtension($uploadedFile->getMimeType());
                $newFileName = $user->getId().'_'.date("ymdHis").'_'.rand(1, 9999).$extension;

                $uploadedFile->move(
                    $_SERVER['DOCUMENT_ROOT'].$this->container->getParameter('upload_path'),
                    $newFileName
                );

                $image->setUrl($newFileName);
                $image->setVotes(0);
                $image->setUser($user);
                $image->setTitle(substr($uploadedFile->getClientOriginalName(), 0, -4));
                $image->setFirstTitle($image->getTitle());
                $image->setSlug($this->container->get('picmnt.utils')->getSlug($newFileName, 0, $user->getId()));
                $image->setFirstSlug($image->getSlug());
                $image->setPubDate(new \DateTime('today'));
                $image->setStatus($imageDefaults['status']);
                $image->getNotifyEmail($imageDefaults['email_noti']);
                $image->setNotifyEmail(true);
                $image->setCategory($em->getRepository('SFMPicmntBundle:Category')->findOneById('6'));
                $em->persist($image);
                $em->flush();

                $imageUtil->resizeImage($imageDefaults['upload_path'].$newFileName, $imageDefaults['size']);
                
                if (!is_dir($imageDefaults['thumbs_path'])) {
                    mkdir($imageDefaults['thumbs_path']);
                }

                $imageUtil->createImageSmall(
                    $imageDefaults['upload_path'].$newFileName,
                    $imageDefaults['thumbs_path'].$newFileName,
                    $imageDefaults['small_size']
                );

                if ($this->container->getParameter('use_ducksoard') === 'yes') {
                    $widget = $this->container->get('ducksboard.widget');
                    $widgetId = $this->container->getParameter('upload_widget');
                    $widget->addToCounter($widgetId);
                }

                return $this->redirect($this->generateUrl('img_edit', array("id_image" => $image->getIdImage())));
            }
        }
        return $this->render('SFMPicmntBundle:Image:upload.html.twig', array('form' => $form->createView()));
    }

    /**
     * Edit an image
     *
     */
    public function editAction($id_image){
        $em = $this->get('doctrine')->getEntityManager();     
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
                $form->bindRequest($request);
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
     */
    public function deleteAction($idImage){
        $em = $this->get('doctrine')->getEntityManager();     
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
    public function showAction($option, $idImage = 0, $category = 'all'){
        $em = $this->get('doctrine')->getEntityManager();
        $paginator = array();

        if ( $option == 'last' ) {
            $image = $em->find('SFMPicmntBundle:Image',$idImage);
            if (!$image){
                $images = $em->getRepository('SFMPicmntBundle:Image')->findFirst('p.idImage DESC', $category);
                $image = $images[0];
            }
            $paginateService = $this->container->get('picmnt.paginator');
            $paginator = $paginateService->getPaginator($option, $image->getIdImage(), $category);
        }
        else if ( $option == 'random' ){
            $images = $em->getRepository('SFMPicmntBundle:Image')->getRandom($category);
            $image = $images[0];
        }
        else if ( $option == 'show' ){
            $image = $em->find('SFMPicmntBundle:Image',$idImage);
        }
        else if ( $option == 'recents'){
            $paginator = $this->get('ideup.simple_paginator');
            $paginator->setItemsPerPage(15);
            $images = $paginator->paginate($em->getRepository('SFMPicmntBundle:Image')->getRecentsDQL($category))->getResult();

            return $this->render('SFMPicmntBundle:Image:showImage.html.twig', array("images"=>$images));
        }
        return $this->render('SFMPicmntBundle:Image:showImage.html.twig', array("image"=>$image, "paginator"=>$paginator));
    }
    
    
    
    /**
     * View an image
     *
     */
    public function viewAction($user, $slug)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $image = $em->getRepository('SFMPicmntBundle:Image')->getByUserSlug($user, $slug);
    
        if (!$image) {
            $e = $this->get('translator')->trans('Picture Not Found');
            throw $this->createNotFoundException($e);
        }
    
        $user = $this->container->get('security.context')->getToken()->getUser();
    
        if ($this->getCurrentUserId() == $image[0]->getUser()->getId()){
            $this->deleteNotifications($image);
        }

        return $this->render('SFMPicmntBundle:Image:viewImageNew.html.twig', array("image"=>$image[0]));
        /* return $this->render('SFMPicmntBundle:Image:viewImage.html.twig', array("image"=>$image[0])); */
    }

    

    /**
     * Delete a notification
     *
     */
    private function deleteNotifications($image){
        $em = $this->get('doctrine')->getEntityManager();
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
