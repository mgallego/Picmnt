<?php

namespace MGP\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    
    public function findAvatarInfo($userId){
	$em = $this->getEntityManager();
	$query = $em->createQuery('
                  SELECT ui.avatar as avatar
                   FROM MGPUserBundle:UserInfo ui
                  WHERE ui.userId = :id');

	$query->setParameter('id', $userId);

	$query->setMaxResults(1);

	return $query->getResult();

    }

    public function getPendingComments($user){

	return $this->getPendingCommentsDQL($user)->getResult();

    }


    public function getPendingCommentsDQL($user){
	$query = $this->getEntityManager()->createQuery('SELECT p image, count(c.notified) pending
                                                     FROM MGPImageBundle:Image p
                                                     JOIN p.user u JOIN p.imageComments c
                                                     WHERE u.username = :username
	                                             AND p.title IS NOT NULL
                                                     AND p.status = 1
						     AND p.slug is not null
                                                     AND c.notified = 0
                                                     GROUP BY p.idImage
                                                     ORDER BY pending DESC
');

	$query->setParameter('username', $user);

	return $query;

    }

    
}
