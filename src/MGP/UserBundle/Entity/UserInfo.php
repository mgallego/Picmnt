<?php

namespace MGP\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * SFM\PicmntBundle\Entity\UserInfo
 *
 * @ORM\Table(name="user_info")
 * @ORM\Entity
 */
class UserInfo
{
    /**
     * @var integer $userId
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;


    /**
     * @var string $name
     *
     * @ORM\Column(name="Name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string $lastName
     *
     * @ORM\Column(name="Last_Name", type="string", length=45, nullable=false)
     */
    private $lastName;

    /**
     * @var string $avatar
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;
 
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="user")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Get userId
     *
     * @return integer $userId
     */
    public function getUserId()
    {
        return $this->userId;
    }


    /**
     * Set userId
     *
     * @param integer $userId
     */
    public function setUserId($userId)
    {
      $this->userId = $userId;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string $lastName
     */
    public function getLastName()
    {
        return $this->lastName;
    }


    /**
     * Set avatar
     *
     * @param string $avatar
     */
    public function setAvatar($avatar){
      $this->avatar = $avatar;
    }

    /**
     * Get avatar
     *
     * @return string $avatar
     */
    public function getAvatar(){
      return $this->avatar;
    }

    /**
     * Set user
     *
     * @param SFM\PicmntBundle\Entity\User $user
     */
    public function setUser(\SFM\PicmntBundle\Entity\User $user)
    {
      $this->user = $user;
    }


    /**
     * Get user
     *
     * @return SFM\PicmntBundle\Entity\User $user
     */
    public function getUser()
    {
      return $this->user;
    }



}