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
	    'avatar' => new \Twig_Function_Method($this, 'avatar')
	    );
    }

    public function avatar($userId){
	$avatar = $this->em->getRepository('SFMPicmntBundle:User')->findAvatar($userId);
	if (!$avatar){
	    return '/bundles/sfmpicmnt/images/user-default.png';
	}
	return '/uploads/avatarsmall/'.$avatar[0]["avatar"];
    }

    public function getName(){
	return 'picmnt';
    }


}
