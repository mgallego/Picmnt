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
                     FROM SFMPicmntBundle:Image p join p.category c WHERE p.title IS NOT NULL AND p.status = 1'.$category)
	    ->getResult();

	$randIdImage = rand($idImageRange[0]['minIdImage'], $idImageRange[0]['maxIdImage']);

	$query = $this->getEntityManager()->createQuery('SELECT p 
                                                     FROM SFMPicmntBundle:Image p
                                                     JOIN p.category c
                                                     WHERE p.idImage >= :randIdImage
	                                             AND p.title IS NOT NULL
                                                     AND p.status = 1'.$category);

	$query->setParameter('randIdImage', $randIdImage);
	$query->setMaxResults(1);

	return $query->getResult();

    }

    public function getByUserSlug($user, $slug){
	$query = $this->getEntityManager()->createQuery('SELECT p 
                                                     FROM SFMPicmntBundle:Image p
                                                     JOIN p.user u
                                                     WHERE p.slug = :slug
                                                     AND u.username = :username
	                                             AND p.title IS NOT NULL
                                                     AND p.status = 1');

	$query->setParameter('slug', $slug);
	$query->setParameter('username', $user);
	$query->setMaxResults(1);

	return $query->getResult();

    }


    public function getByUser($user){

	return $this->getByUserDQL($user)->getResult();

    }


    public function getByUserDQL($user){
	$query = $this->getEntityManager()->createQuery('SELECT p as image, count(c.notified) as notified  
                                                     FROM SFMPicmntBundle:Image p
                                                     JOIN p.user u join p.imageComments c
                                                     WHERE u.username = :username
	                                             AND p.title IS NOT NULL
                                                     AND p.status = 1
                                                     AND c.notified = 0
						     AND p.slug is not null
                                                     GROUP BY p.idImage
                                                     ORDER BY notified DESC');

	//	select i.*, count(c.notified) from Image_Comment c, Image i  where notified  = 0 and i.id_image = c.id_image group by i.id_image;

	$query->setParameter('username', $user);

	return $query;

    }

    
    public function getLastImages($maxResults){
	$query = $this->getEntityManager()->createQuery('SELECT p 
                                                     FROM SFMPicmntBundle:Image p
	                                             WHERE p.title IS NOT NULL
                                                       AND p.status = 1
                                                     ORDER BY p.idImage DESC');

	$query->setMaxResults($maxResults);

	return $query->getResult();

    }


    public function getMostComment($maxResults){
	return $this->getMostCommentDQL($maxResults)->getResult();
    }

    public function getMostCommentDQL($maxResults){

        $qb = $this->_em->createQueryBuilder();

        $qb->add('select', 'c as comment, count(c) as cCount')
            ->add('from', 'SFMPicmntBundle:ImageComment c')
	    ->join('c.image','p')
            ->add('where', 'p.title is not null AND p.status = 1') 
	    ->addGroupby('p.idImage')
            ->addOrderBy('cCount', 'DESC')
            ->setMaxResults(10);


	$query = $qb->getQuery();  
	
	return $query;
	//return $query->getResult();

    }



    public function findNext($idImage, $orderBy, $category = 'All')
    {
	$category = $this->getCategoryCondition($category);

        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
            ->add('where', 'p.idImage > :idImage AND p.status = 1'.$category)   
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
            ->add('where', 'p.idImage < :idImage AND p.status = 1'.$category)   
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
	    ->add('where','1 = 1 and p.status = 1'.$category)
	    ->add('orderBy', $orderBy)
	    ->setMaxResults(1);

        $query = $qb->getQuery();  

        return $query->getResult();

    }
    
}
