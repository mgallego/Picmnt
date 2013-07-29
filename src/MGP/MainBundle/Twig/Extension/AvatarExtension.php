<?php

namespace MGP\MainBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;

class AvatarExtension extends \Twig_Extension
{

    /**
     * @var EntityManager
     */
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get function
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('avatar', [$this, 'avatar']),
            new \Twig_SimpleFunction('avatarByUsername', [$this, 'avatarByUsername']),
            new \Twig_SimpleFunction('existsAvatar', [$this, 'existsAvatar']),
            new \Twig_SimpleFunction('getEmail', [$this, 'getEmail']),
        ];
    }

    /**
     * Avatar By username
     *
     * @param string $username
     * @param string size
     *
     * @return string
     */
    public function avatarByUsername($username, $size = 'small')
    {
        $user = $this->em->getRepository('MGPUserBundle:User')->findOneByUsername($username);

        if (!$user->getAvatar()) {
            return '/bundles/mgpmain/images/user.svg';
        }
        return '/uploads/avatar'.$size.'/'.$user->getAvatar();
    }

    /**
     * Avatar
     *
     * @param integer $userId
     *
     * @return string
     */
    public function avatar($userId)
    {
        $user = $this->em->getRepository('MGPUserBundle:User')->findOneById($userId);

        if (!$user->getAvatar()) {
            return '/bundles/mgpmain/images/user.svg';
        }
        return '/uploads/avatarsmall/'.$user->getAvatar();
    }

    /**
     * Exists Avatar
     *
     * @param string $username
     *
     * @return boolean
     */
    public function existsAvatar($username)
    {
        $user = $this->em->getRepository('MGPUserBundle:User')->findOneByUsername($username);

        if (!$user->getAvatar()) {
            return false;
        }
        return true;
    }

    /**
     * Get Email
     *
     * @param string $username
     *
     * @return string
     */
    public function getEmail($username)
    {
        $user = $this->em->getRepository('MGPUserBundle:User')->findOneByUsername($username);

        return $user->getEmail();

    }

    /**
     * getEmail
     *
     * @return string
     */
    public function getName()
    {
        return 'avatar_extension';
    }
}
