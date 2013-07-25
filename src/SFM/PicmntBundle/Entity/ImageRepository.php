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



    public function getRandom($category = 'all')
    {
        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'min(p.idImage) minIdImage, max(p.idImage) maxIdImage')
            ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
            ->where('p.title IS NOT NULL AND p.status = 1');

	if ($category != 'all'){
            $qb->add('where', 'c.name = :category')->setParameter('category',$category);
	}

	$idImageRange = $qb->getQuery()->getResult();  

        $randIdImage = rand($idImageRange[0]['minIdImage'], $idImageRange[0]['maxIdImage']);

        $query = $this->_em->createQueryBuilder();

        $query->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
            ->where('p.title IS NOT NULL AND p.status = 1 AND p.idImage >= :randIdImage');

        if ($category != 'all') {
            $query->add('where', 'c.name = :category')->setParameter('category',$category);
        }

	$query->setParameter('randIdImage', $randIdImage);
	$query->setMaxResults(1);

	return $query->getQuery()->getSingleResult();

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


    public function getByUsername($username, $offset = 0, $maxResults = 20){

	return $this->getByUserDQL($username)
            ->setFirstResult($offset)
            ->setMaxResults($maxResults)
            ->getResult();

    }


    public function getByUserDQL($username){
	$query = $this->getEntityManager()->createQuery('SELECT p 
                                                         FROM SFMPicmntBundle:Image p
                                                         JOIN p.user u
                                                         WHERE u.username = :username
                                                         AND p.title IS NOT NULL
                                                         AND p.status = 1
                                                         AND p.slug is not null
                                                         ORDER by p.idImage DESC
                                                         ');

	//	select i.*, count(c.notified) from Image_Comment c, Image i  where notified  = 0 and i.id_image = c.id_image group by i.id_image;

	$query->setParameter('username', $username);

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


    public function findNext($idImage, $orderBy, $category = 'all')
    {
        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
            ->add('where', 'p.idImage > :idImage AND p.status = 1');


        if ($category != 'all'){
            $qb->add('where', 'c.name = :category')->setParameter('category',$category);
	}
        
        
        $qb->add('orderBy', $orderBy)
            ->setParameter('idImage', $idImage)
            ->setMaxResults(1);
        
      
	$query = $qb->getQuery();  

        return $query->getResult();

    }
    

    public function findPrevious($idImage, $orderBy, $category = 'all' )
    {
        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
            ->add('where', 'p.idImage < :idImage AND p.status = 1');

        if ($category != 'all'){
            $qb->add('where', 'c.name = :category')->setParameter('category',$category);
	}


        $qb->add('orderBy', $orderBy)
            ->setParameter('idImage', $idImage)
            ->setMaxResults(1);
        
        $query = $qb->getQuery();  

        return $query->getResult();

    }

    
    public function findFirst($orderBy, $category = 'all')
    {
        
	$category = $this->getCategoryCondition($category);

        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
	    ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
	    ->add('where','1 = 1 and p.status = 1');

        if ($category != 'all'){
            $qb->add('where', 'category.name = :category')->setParameter('category',$category);
	}

        $qb->add('orderBy', $orderBy)
	    ->setMaxResults(1);

        $query = $qb->getQuery();  

        return $query->getResult();

    }

    public function getPendingComments($user){
	$query = $this->getEntityManager()->createQuery('SELECT count(c.notified)  as total
                                                         FROM SFMPicmntBundle:ImageComment c
                                                         JOIN c.image i JOIN i.user u
                                                         WHERE i.slug IS NOT NULL
                                                         AND u.username = :username
                                                         AND i.status = 1
                                                         AND c.notified = 0
                                                         ');

	$query->setParameter('username', $user);
	$query->setMaxResults(1);

	return $query->getResult();

    }

    public function getPendingCommentsByImage($idImage){
	$query = $this->getEntityManager()->createQuery('SELECT count(c.notified)  as total
                                                         FROM SFMPicmntBundle:ImageComment c
                                                         JOIN c.user u JOIN c.image i
                                                         WHERE i.slug IS NOT NULL
                                                         AND i.idImage = :idImage
                                                         AND i.status = 1
                                                         AND c.notified = 0');


	$query->setParameter('idImage', $idImage);
	$query->setMaxResults(1);

	return $query->getResult();

    }


    public function findByCategoryAndOrder($category, $orderField, $offset = 0, $maxResults = 30)
    {
        return $this->findByCategoryAndOrderDQL($category, $orderField)
            ->setFirstResult($offset)
            ->setMaxResults($maxResults)
            ->getResult();
    }


    public function findByCategoryAndOrderDQL($category, $orderField)
    {
        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
	    ->join('p.category','c')
            ->where('p.status = 1');

	if ($category != 'all'){
            $qb->add('where', 'c.name = :category')->setParameter('category',$category);
	}
        
        $qb->orderBy('p.'.$orderField,'DESC');

        $qb->addOrderBy('p.idImage','DESC');
        
        return $qb->getQuery();
    }


    public function hasVoted($idImage){
    
	$user = $this->container->get('security.context')->getToken()->getUser();

	$repository = $this->get('doctrine')
	    ->getEntityManager()
	    ->getRepository('SFMPicmntBundle:UserVote');

	$query = $repository->createQueryBuilder('uv')
	    ->where('uv.userId = :userId AND uv.idImage = :idImage')
	    ->setParameters(array('userId'=>$user->getId(), 'idImage'=>$idImage))
	    ->getQuery();

	$userVote = $query->getResult();
    
    
	if (!$userVote) { 
	    return 0;
	}
	else{
	    return 1;
	}

    }
    
}
