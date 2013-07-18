<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SFM\PicmntBundle\Repositories\ImageUp;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\User;
use SFM\PicmntBundle\Form\ImageType;
use SFM\PicmntBundle\Form\ImageUpType;
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
     * Upload an Image and set the defaults data
     *
     * @Route ("/img/upload", name="img_upload")
     */
    public function uploadAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $image = new Image();
        $imageUp = new ImageUp();
        $em = $this->get('doctrine')->getEntityManager();
        $form = $this->createForm(new ImageUpType(), $imageUp);

        if ($this->get('request')->getMethod() == 'POST') {
            $form->handleRequest($request);

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
                if ($this->container->getParameter('use_ducksboard') === 'yes') {
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
     * @Route ("/img/edit/{id_image}", name="img_edit")     
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
     * @Route ("/img/delete/{idImage}", name="img_delete")     
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
     * @Route ("/{category}/{option}/{idImage}", name="img_show",
     * defaults={"idImage"=0},
     * requirements={"category" = "all|portraits|landscapes|animals|sports|buildings|others", "option" = "random|show|recents"})     
     */
    public function showAction($option, $idImage = 0, $category = 'all'){

        $em = $this->get('doctrine')->getEntityManager();
        $paginator = array();

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
                    ->getRecents($category, null, $imagesPerPage);
                $loadMore = true;
                if (count($images) < $imagesPerPage) {
                    $loadMore = false;
                }
                return $this->render('SFMPicmntBundle:Image:recents.html.twig', array("images"=>$images, 'loadMore' => $loadMore));
                break;
        }
        
        return $this->render('SFMPicmntBundle:Image:viewImage.html.twig', array("image"=>$image, "paginator"=>$paginator));
    }

    /**
     * View an image
     *
     * @Route ("/ajax/images/get_more", name="ajax_img_get_more")     
     */
    public function getMoreImagesAction(Request $request)
    {
        $images = $this->get('sfm_picmnt.thumb_manager')->getMoreThumbs($request, $this->container
            ->get('liip_imagine.controller'));
        return new Response(json_encode($images));
    }

    /**
     * View an image
     *
     * @Route ("/view/{user}/{slug}", name="img_view")     
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

        return $this->render('SFMPicmntBundle:Image:viewImage.html.twig', array("image"=>$image[0]));
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
