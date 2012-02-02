<?php

namespace SFM\PicmntBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use  SFM\PicmntBundle\Util\Util;

/**
 * SFM\PicmntBundle\Entity\Image
 *
 * @ORM\Table(name="Image")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="SFM\PicmntBundle\Entity\ImageRepository")
 */
class Image {

    /**
     * @var integer $idImage
     *
     * @ORM\Column(name="id_image", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idImage;

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
     * @Assert\MaxLength(255)
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
     * @var string $tags
     *
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     *
     *  @Assert\MaxLength(255)
     */
    private $tags;

    /**
     * @var integer $votes
     *
     * @ORM\Column(name="votes", type="integer", nullable=true)
     */
    private $votes;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="images", cascade={"remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="image")
     * @ORM\JoinTable(name="User_Vote",
     *      joinColumns={@ORM\JoinColumn(name="id_image", referencedColumnName="id_image")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    protected $userVotes;
    
    /**
     * @ORM\OneToMany(targetEntity="ImageComment", mappedBy="image", cascade={"persist"})
     */
    private $imageComments;


    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="images", cascade={"remove"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

   
    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     *
     * @Assert\MaxLength(255)
     */
    private $slug;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Assert\DateTime
     */
    protected $pubDate;


    /**
     * @ORM\Column(type="integer", nullable=false)
     *
     */
    protected $status;



    public function __construct()
    {
      $this->userVotes = new \Doctrine\Common\Collections\ArrayCollection();
      $this->imageComments = new \Doctrine\Common\Collections\ArrayCollection();
    }



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
     * @param SFM\PicmntBundle\Entity\Category $category
     */
    public function setCategory(\SFM\PicmntBundle\Entity\Category $category){
      $this->category = $category;
    }

    /**
     * Get category
     *
     * @return SFM\PicmntBundle\Entity\Category $category $category
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

    /**
     * Set votes
     *
     * @param integer $votes
     */
    public function setVotes($votes){
      $this->votes = $votes;
    }

    /**
     * get votes
     *
     * @return integer $votes
     */
    public function getVotes(){
      return $this->votes;
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

    /**
     * Add userVote
     *
     * @param SFM\PicmntBundle\Entity\User $userVotes
     */
    public function addUserVotes(\SFM\Picmntbundle\Entity\User $userVotes)
    {

      $this->userVotes[] = $userVotes;
    }

    public function hasUserVotes(\SFM\PicmntBundle\Entity\User $user)
    {
      foreach ($this->userVotes as $value)
	{
	  if ($value->getId() == $user->getuserId()){
	    return true;
	  }
	}
      return false;
    }

    /**
     * Get userVote
     *
     * @return Doctrine\Commmon\Collections\Collencion $userVote
     */
    public function getUserVotes()
    {
      return $this->userVotes;
    }


    public function sumVotes(){
      $this->votes = $this->getVotes() + 1;
    }

 
    /**
     * Add imageComments
     *
     * @param SFM\PicmntBundle\Entity\ImageComment $imageComments
     */
    public function addImageComments(\SFM\PicmntBundle\Entity\ImageComment $imageComments)
    {
      $this->imageComments[] = $imageComments;
    }

    /**
     * Get imageComments
     *
     * @return SFM\PicmntBundle\Entity\Image $imageComments
     */
    public function getImageComments()
    {
      return $this->imageComments;
    }   

    
    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug){
      $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug(){
      return $this->slug;
    }
    

    /**
     * Set pubDate
     *
     * @param datetime $pubDate
     */
    public function setPubDate($pubDate){
      $this->pubDate = $pubDate;
    }

    /**
     * Get pubDate
     *
     * @return datetime $pubDate
     */
    public function getPubDate(){
      return $this->pubDate;
    }
    
    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status){
	//0 -- removed ; 1 -- normal
      $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer status
     */
    public function getStatus(){
      return $this->status;
    }
    

}