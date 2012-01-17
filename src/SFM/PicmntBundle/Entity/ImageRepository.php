<?php

namespace SFM\PicmntBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository
{


    private function getCategoryCondition($category){

	if ($category != 'all'){
	    return ' AND c.name = \''.$category.'\'';
	}
	return '';

    }
	

    public function getRandom($category = 'All')
    {

	$category = $this->getCategoryCondition($category);

	$idImageRange = $this->getEntityManager()
	    ->createQuery('SELECT min(p.idImage) minIdImage, max(p.idImage) maxIdImage 
                     FROM SFMPicmntBundle:Image p join p.category c WHERE p.title IS NOT NULL'.$category)
	    ->getResult();

	$randIdImage = rand($idImageRange[0]['minIdImage'], $idImageRange[0]['maxIdImage']);

	$query = $this->getEntityManager()->createQuery('SELECT p 
                                                     FROM SFMPicmntBundle:Image p
                                                     JOIN p.category c
                                                     WHERE p.idImage >= :randIdImage
	                                             AND p.title IS NOT NULL'.$category);

	$query->setParameter('randIdImage', $randIdImage);
	$query->setMaxResults(1);

	return $query->getResult();

    }
    

    public function findNext($idImage, $orderBy, $category = 'All')
    {
	$category = $this->getCategoryCondition($category);

        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
            ->add('where', 'p.idImage > :idImage'.$category)   
            ->add('orderBy', $orderBy)
            ->setParameter('idImage', $idImage)
            ->setMaxResults(1);

      
	$query = $qb->getQuery();  

        return $query->getResult();

    }
    

    public function findPrevious($idImage, $orderBy, $category = 'All' )
    {
        
	$category = $this->getCategoryCondition($category);

        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
            ->add('where', 'p.idImage < :idImage'.$category)   
            ->add('orderBy', $orderBy)
            ->setParameter('idImage', $idImage)
            ->setMaxResults(1);
        
        $query = $qb->getQuery();  

        return $query->getResult();

    }

    
    public function findFirst($orderBy, $category = 'All')
    {
        
	$category = $this->getCategoryCondition($category);

        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
	    ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
	    ->add('where','1 = 1'.$category)
	    ->add('orderBy', $orderBy)
	    ->setMaxResults(1);

        $query = $qb->getQuery();  

        return $query->getResult();

    }
    
}
