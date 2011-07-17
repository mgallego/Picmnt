<?php

namespace SFM\PicmntBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository
{
    


  /**
   * @return type image
   */
  public function getRandom()
  {
   
    $idImageRange = $this->getEntityManager()
      ->createQuery('SELECT min(p.idImage) minIdImage, max(p.idImage) maxIdImage 
                     FROM SFMPicmntBundle:Image p')
      ->getResult();

    $randIdImage = rand($idImageRange[0]['minIdImage'], $idImageRange[0]['maxIdImage']);


    $qb = $this->_em->createQueryBuilder();
        
    $qb->add('select', 'p')
      ->add('from', 'SFMPicmntBundle:Image p')
      ->add('where', 'p.idImage >= :randIdImage')   
      ->setParameter('randIdImage', $randIdImage)
      ->setMaxResults(1 );
        
    $query = $qb->getQuery();  

    return $query->getResult();


  }
    


    /**
     *
     * @param type $idImage
     * @param type $orderBy 
     * @return type 
     */
    public function findNext($idImage, $orderBy)
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
    

    public function findPrevious($idImage, $orderBy)
    {
        
        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
            ->add('from', 'SFMPicmntBundle:Image p')
            ->add('where', 'p.idImage > :idImage')   
            ->add('orderBy', $orderBy)
            ->setParameter('idImage', $idImage)
            ->setMaxResults(1 );
        
        $query = $qb->getQuery();  

        return $query->getResult();

    }

    
     public function findFirst($orderBy)
    {
        
        $qb = $this->_em->createQueryBuilder();
        
        $qb->add('select', 'p')
	  ->add('from', 'SFMPicmntBundle:Image p');
	  //->add('orderBy', $orderBy);
	  //->setMaxResults(1);
        
        $query = $qb->getQuery();  

        return $query->getResult();

    }
    
    
}
