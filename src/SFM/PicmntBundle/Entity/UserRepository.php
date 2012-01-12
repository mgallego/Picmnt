<?php

namespace SFM\PicmntBundle\Entity;

use Doctrine\ORM\EntityRepository;
use SFM\PicmntBundle\Entity\UserInfo;

class UserRepository extends EntityRepository
{
    
    public function findAvatar($userId){
	$em = $this->getEntityManager();
	$query = $em->createQuery('
                  SELECT ui.avatar 
                   FROM SFMPicmntBundle:UserInfo ui
                  WHERE ui.userId = :id');

	$query->setParameter('id', $userId);

	$query->setMaxResults(1);

	return $query->getResult();

    }
    
}
