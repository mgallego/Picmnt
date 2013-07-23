<?php

namespace SFM\PicmntBundle\Model\Type;

use SFM\PicmntBundle\Util\ArrayConverterTrait;

/**
* Thumtype
*
* @author Moises Gallego <moisesgallego@gmail.com>
* @copyright Moises Gallego 2013
*/
class ThumbType
{
    //use ArrayConverterTrait;
    
    protected $imageId;

    protected $url;

    protected $imageViewUrl;
    
    protected $slug;

    protected $title;

    protected $category;

    protected $authorLabel;
    
    protected $userId;

    protected $userUrl;

    protected $username;

    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

    }

    public function getImageId()
    {
        return $this->imageId;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setImageViewUrl($imageViewUrl)
    {
        $this->imageViewUrl = $imageViewUrl;
    }

    public function getImageViewUrl()
    {
        return $this->imageViewUrl;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setAuthorLabel($authorLabel)
    {
        $this->authorLabel = $authorLabel;
    }

    public function getAuthorLabel()
    {
        return $this->authorLabel;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserUrl($userUrl)
    {
        $this->userUrl = $userUrl;
    }

    public function getUserUrl()
    {
        return $this->userUrl;
    }
    
    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
