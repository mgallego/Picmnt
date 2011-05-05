<?php

namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SFM\PicmntBubnle\Entity\Images;
use SFM\PicmntBundle\Entity\User;
use FOS\UserBundle\Entity\UserManager;

class ImageController extends Controller
{

  //Upload an image url into the database
    /**
    * @extra:Route("/img/upload", name="upload")
    * @extra:Template()
    */
    public function uploadAction()
    {
      //testing variables in templates
      $foo = 'Testing variables in template';
      

      //entering in the security context and retrieving the user
      $user = $this->container->get('security.context')->getToken()->getUser();

      //load the username
      $foo = $user->getUsername();

      $bar = $user->getId();

      return array('foo' => $foo, 'bar' => $bar);
    }


   


}
