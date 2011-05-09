<?php

namespace SFM\PicmntBundle\Entity;

/**
 * SFM\PicmntBundle\Entity\Image
 *
 * @orm:Table(name="Image")
 * @orm:Entity
 */
class Image
{

    /**
     * @var integer $idImage
     *
     * @orm:Column(name="id_image", type="integer", nullable=false)
     * @orm:Id
     * @orm:GeneratedValue(strategy="AUTO")
     */
    private $idImage;

    /**
     * @var integer $userId
     *
     * @orm:Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string $url
     *
     * @orm:Column(name="Url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * Set idImage
     *
     * @param integer $idImage
     */
    public function setIdImage($idImage)
    {
        $this->idImage = $idImage;
    }

    /**
     * Get idImage
     *
     * @return integer $idImage
     */
    public function getIdImage()
    {
        return $this->idImage;
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
     * Get userId
     *
     * @return integer $userId
     */
    public function getUserId()
    {
        return $this->userId;
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

}