<?php

namespace SFM\PicmntBundle\Util;

use Doctrine\ORM\EntityManager;

class Paginator{

    private $em;
    private $option;
    private $idImage;
    private $category;



    public function __construct(EntityManager $em){
	$this->em = $em;
    }


    /**
     * Get a simple paginator
     *
     */
    public function getPaginator($option, $idImage, $category = 'all'){
	$this->option = $option;
	$this->idImage = $idImage;
	$this->category = $category;

	return array('imgNext'=>$this->getPosition('Next'), 'imgPrevious'=>$this->getPosition('Previous'));
    }



    /**
     * position ['Next'|'Previous']
     *
     */
    private function getPosition($position){
	$findMethod = 'find'.$position;
	$desc = null;
	if ($position === 'Previous'){
	    $desc = ' DESC';
	}
	if ($this->option == 'last'){
	    $images = $this->em->getRepository('SFMPicmntBundle:Image')->$findMethod($this->idImage, 'p.idImage'.$desc, $this->category);
    	    if (!$images){
		$images = $this->em->getRepository('SFMPicmntBundle:Image')->findFirst('p.idImage DESC', $this->category);    
	    }
	}
	$image = $images[0];

	return $image->getIdImage();
    }
}