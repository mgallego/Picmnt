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
	$user = $this->em->getRepository('SFMPicmntBundle:User')->findById($userId);

	if (!$user[0]->getAvatar()){
	    return '/bundles/sfmpicmnt/images/user.svg';
	}
	return '/uploads/avatarsmall/'.$user[0]->getAvatar();
    }

    public function avatarByUsername($username){
	$user = $this->em->getRepository('SFMPicmntBundle:User')->findByUsername($username);

	if (!$user[0]->getAvatar()){
	    return '/bundles/sfmpicmnt/images/user.svg';
	}
	return '/uploads/avatarsmall/'.$user[0]->getAvatar();
    }


    public function getName(){
	return 'picmnt';
    }


}
