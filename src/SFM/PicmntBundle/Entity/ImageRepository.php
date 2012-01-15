<?php

namespace SFM\PicmntBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository
{


    private function getCategoryCondition($idCategory){

	if ($idCategory != 0){
	    return ' AND c.id = '.$idCategory;
	}
	return '';

    }
	

    public function getRandom($idCategory = 0)
    {

	$category = $this->getCategoryCondition($idCategory);

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
    

    public function findNext($idImage, $orderBy)
    {
        
        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
            ->add('where', 'p.idImage > :idImage')   
            ->add('orderBy', $orderBy)
            ->setParameter('idImage', $idImage)
            ->setMaxResults(1);

      
	$query = $qb->getQuery();  

        return $query->getResult();

    }
    

    public function findPrevious($idImage, $orderBy)
    {
        
        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
            ->add('where', 'p.idImage < :idImage')   
            ->add('orderBy', $orderBy)
            ->setParameter('idImage', $idImage)
            ->setMaxResults(1);
        
        $query = $qb->getQuery();  

        return $query->getResult();

    }

    
    public function findFirst($orderBy)
    {
        
        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
	    ->add('from', 'SFMPicmntBundle:Image p')
	    ->add('orderBy', $orderBy)
	    ->setMaxResults(1);
        
        $query = $qb->getQuery();  

        return $query->getResult();

    }
    
}
