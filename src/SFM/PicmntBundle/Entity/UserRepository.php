<?php

namespace SFM\PicmntBundle\Entity;

use Doctrine\ORM\EntityRepository;
use SFM\PicmntBundle\Entity\User;

class UserRepository extends EntityRepository
{
    
    public function findAvatarInfo($userId){
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
