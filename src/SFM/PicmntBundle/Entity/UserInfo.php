<?php

namespace SFM\PicmntBundle\Entity;

/**
 * SFM\PicmntBundle\Entity\UserInfo
 *
 * @orm:Table(name="User_Info")
 * @orm:Entity
 */
class UserInfo
{

  
    /**
     * @var integer $userId
     *
     * @orm:Column(name="User_id", type="integer", nullable=false)
     * @orm:Id
     * @orm:GeneratedValue(strategy="IDENTITY")
     */
    private $userId;


    /**
     * @var string $name
     *
     * @orm:Column(name="Name", type="string", length=45, nullable=false)
     */
    private $name;

    /**
     * @var string $lastName
     *
     * @orm:Column(name="Last_Name", type="string", length=45, nullable=false)
     */
    private $lastName;


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
     * Set user1
     *
     * @param SFM\PicmntBundle\Entity\User $user1
     */
    public function setUser1(\SFM\PicmntBundle\Entity\User $user1)
    {
        $this->user1 = $user1;
    }


}