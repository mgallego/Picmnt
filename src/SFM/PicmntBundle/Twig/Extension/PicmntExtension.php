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
	    'avatarByUsername' => new \Twig_Function_Method($this, 'avatarByUsername')
	    );
    }

    public function avatar($userId){
	$user = $this->em->getRepository('SFMPicmntBundle:User')->findOneById($userId);

	if (!$user->getAvatar()){
	    return '/bundles/sfmpicmnt/images/user.svg';
	}
	return '/uploads/avatarsmall/'.$user->getAvatar();
    }

    public function avatarByUsername($username, $size = 'small'){
	$user = $this->em->getRepository('SFMPicmntBundle:User')->findOneByUsername($username);

	if (!$user->getAvatar()){
	    return '/bundles/sfmpicmnt/images/user.svg';
	}
	return '/uploads/avatar'.$size.'/'.$user->getAvatar();
    }


    public function getName(){
	return 'picmnt';
    }


}
