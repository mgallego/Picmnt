<?php 

namespace SFM\PicmntBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class PicmntExtension extends \Twig_Extension
{

    private $em;
    private $translator;

    public function __construct( $em = null,  Translator $translator)
    {
      
        $this->em = $em;
	$this->translator  = $translator;
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
	  'getEmail'=> new \Twig_Function_Method($this, 'getEmail'),
	  'getExif'=> new \Twig_Function_Method($this, 'getExif')

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


    public function getExif($url){
	@$image_exif = exif_read_data('uploads/'.$url, 'IFD0');

      $markup = '';

      $markStart = '<h3><a href="#">'.$this->translator->trans('Exif Data').'</a></h3><div>';
      $markEnd = '</div>';


      
      if ($image_exif['Model'] != ''){
	$markup = $markup.'<p>'.$this->translator->trans('Camera').': '.$image_exif["Model"].'</p>';
      }
      if ($image_exif['DateTime'] != ''){
	$markup = $markup.'<p>'.$this->translator->trans('Date').': '.$image_exif["DateTime"].'</p>';
      }
      if ($image_exif['ExposureTime'] != ''){
	$markup = $markup.'<p>'.$this->translator->trans('Exposure Time').': '.$image_exif["ExposureTime"].'seg</p>';
      }
      if ($image_exif['FocalLength'] != ""){
	$Focal = explode("/", $image_exif['FocalLength']);
	$markup = $markup.'<p>'.$this->translator->trans('Lens').': '.round($Focal[0] / $Focal[1]).'mm</p>';
      }
      if ($image_exif['FNumber'] != ""){
	$FNumber = explode("/", $image_exif['FNumber']);
	$markup = $markup.'<p>'.$this->translator->trans('Aperture').': f/'.$FNumber[0] / $FNumber[1].'</p>';
      }
      if ($image_exif['ISOSpeedRatings'] != 0){
	$markup = $markup.'<p>ISO: '.$image_exif["ISOSpeedRatings"].'</p>';
      }
	
      if ($markup != ''){
	$markup = $markStart.$markup.$markEnd;
      }
	
      return $markup;
    }


    public function getName(){
	return 'picmnt';
    }

}
