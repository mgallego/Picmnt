<?php

namespace SFM\PicmntBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * SFM\PicmntBundle\Entity\Image
 *
 * @ORM\Table(name="Image")
 * @ORM\Entity
 */
class Image
{

    /**
     * @var integer $idImage
     *
     * @ORM\Column(name="id_image", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idImage;

    /**
     * @var integer $userId
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     * @var string $url
     *
     * @ORM\Column(name="Url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     *
     *  @Assert\MaxLength(255)
     */
    private $title;

    /**
     * @var string $decription
     * 
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     *
     * @Assert\MaxLength(500)
     */
    private $description;

    /**
     * @var integer $category
     *
     * @ORM\Column(name="category", type="integer", nullable=true)
     */
    private $category;

    /**
     * @var string $tags
     *
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     *
     *  @Assert\MaxLength(255)
     */
    private $tags;

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

    
    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title){
      $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle(){
      return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description){
      $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription(){
      return $this->description;
    }

    /**
     * Set category
     *
     * @param integer $category
     */
    public function setCategory($category){
      $this->category = $category;
    }

    /**
     * Get category
     *
     * @return integer $category
     */
    public function getCategory(){
      return $this->category;
    }

    /**
     * Set tags
     *
     * @param string $tags
     */
    public function setTags($tags){
      $this->tags = $tags;
    }
    
    /**
     * Get tags
     *
     * @return string $tags
     */
    public function getTags(){
      return $this->tags;
    }

}