<?php 

namespace SFM\PicmntBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;


class PicmntExtension extends \Twig_Extension
{

    private $em;

    public function __construct( $em = null)
    {
        $this->em = $em;
    }

    public function getEm()
    {
        return $this->em;
    }


    public function getFunctions(){
	return array(
	  'avatar' => new \Twig_Function_Method($this, 'avatar'),
	  'avatarByUsername' => new \Twig_Function_Method($this, 'avatarByUsername'),
	  'totalPendingComments'=> new \Twig_Function_Method($this, 'totalPendingComments'),
	  'imagePendingComments'=> new \Twig_Function_Method($this, 'imagePendingComments'),
	  'existsAvatar'=> new \Twig_Function_Method($this, 'existsAvatar'),
	  'getEmail'=> new \Twig_Function_Method($this, 'getEmail')

	    );
    }

    public function avatar($userId){
	$user = $this->em->getRepository('SFMPicmntBundle:User')->findOneById($userId);

	if (!$user->getAvatar()){
	    return '/bundles/sfmpicmnt/images/user.svg';
	}
	return '/uploads/avatarsmall/'.$user->getAvatar();
    }

    public function existsAvatar($username){
	$user = $this->em->getRepository('SFMPicmntBundle:User')->findOneByUsername($username);

	if (!$user->getAvatar()){
	  return False;
	}
	return True;
    }

    public function getEmail($username){
      $user = $this->em->getRepository('SFMPicmntBundle:User')->findOneByUsername($username);

      return $user->getEmail();

    }

    public function avatarByUsername($username, $size = 'small'){
	$user = $this->em->getRepository('SFMPicmntBundle:User')->findOneByUsername($username);

	if (!$user->getAvatar()){
	    return '/bundles/sfmpicmnt/images/user.svg';
	}
	return '/uploads/avatar'.$size.'/'.$user->getAvatar();
    }

    public function totalPendingComments($username){
      $pending = $this->em->getRepository('SFMPicmntBundle:image')->getPendingComments($username);

      if ($pending){
	return $pending[0]["total"];
      }
      return null;
    }


    public function imagePendingComments($idImage){
      $pending = $this->em->getRepository('SFMPicmntBundle:image')->getPendingCommentsByImage($idImage);

      if ($pending){
	return $pending[0]["total"];
      }
      return null;
    }


    public function getName(){
	return 'picmnt';
    }


}
