<?php

namespace SFM\PicmntBundle\Util;
use Doctrine\ORM\EntityManager;

class Util{

    private $em;

    public function __construct( $em = null)
    {
        $this->em = $em;
    }

    public function getEm()
    {
        return $this->em;
    }

    public function getSlug($cadena, $idImage, $userId, $separador = '-')
    {
	$slug = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);
	$slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
	$slug = strtolower(trim($slug, $separador));
	$slug = preg_replace("/[\/_|+ -]+/", $separador, $slug);
	if ($this->existsSlug($slug,$userId)){
	    return $slug.'_'.$idImage;
	}
	return $slug;
    }

    public function existsSlug($slug, $userId){
	$query = $this->em->createQuery('SELECT count(p) 
                                                     FROM SFMPicmntBundle:Image p
                                                     JOIN p.user u
                                                     WHERE p.slug = :slug
	                                             AND u.id = :userId');

	$query->setParameter('userId', $userId);
	$query->setParameter('slug', $slug);
	$query->setMaxResults(1);
	$result =  $query->getResult();
	
	if ($result[0][1] == 0){
	    return False;
	}
	else{
	    return True;
	}
    }

}