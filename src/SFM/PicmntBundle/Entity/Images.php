<?php

namespace SFM\PicmntBundle\Entity;

/**
 * SFM\PicmntBundle\Entity\Images
 *
 * @orm:Table(name="Images")
 * @orm:Entity
 */
class Images
{
    /**
     * @var integer $idimage
     *
     * @orm:Column(name="idimage", type="integer", nullable=false)
     * @orm:Id
     * @orm:GeneratedValue(strategy="NONE")
     */
    private $idimage;

    /**
     * @var integer $userInfoUserId
     *
     * @orm:Column(name="User_Info_User_id", type="integer", nullable=false)
     * @orm:Id
     * @orm:GeneratedValue(strategy="NONE")
     */
    private $userInfoUserId;

    /**
     * @var string $url
     *
     * @orm:Column(name="Url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var UserInfo
     *
     * @orm:ManyToOne(targetEntity="UserInfo")
     * @orm:JoinColumns({
     *   @orm:JoinColumn(name="User_Info_User_id", referencedColumnName="User_id")
     * })
     */
    private $userInfoUser;



    /**
     * Set idimage
     *
     * @param integer $idimage
     */
    public function setIdimage($idimage)
    {
        $this->idimage = $idimage;
    }

    /**
     * Get idimage
     *
     * @return integer $idimage
     */
    public function getIdimage()
    {
        return $this->idimage;
    }

    /**
     * Set userInfoUserId
     *
     * @param integer $userInfoUserId
     */
    public function setUserInfoUserId($userInfoUserId)
    {
        $this->userInfoUserId = $userInfoUserId;
    }

    /**
     * Get userInfoUserId
     *
     * @return integer $userInfoUserId
     */
    public function getUserInfoUserId()
    {
        return $this->userInfoUserId;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set userInfoUser
     *
     * @param SFM\PicmntBundle\Entity\UserInfo $userInfoUser
     */
    public function setUserInfoUser(\SFM\PicmntBundle\Entity\UserInfo $userInfoUser)
    {
        $this->userInfoUser = $userInfoUser;
    }

    /**
     * Get userInfoUser
     *
     * @return SFM\PicmntBundle\Entity\UserInfo $userInfoUser
     */
    public function getUserInfoUser()
    {
        return $this->userInfoUser;
    }
}