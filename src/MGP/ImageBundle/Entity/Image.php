<?php

namespace MGP\ImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SFM\PicmntBundle\Entity\Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="MGP\ImageBundle\Entity\ImageRepository")
 *
 */
class Image
{
    private $temp;
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     *
     * @Assert\Length(max = "255")
     */
    private $title;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * @var string $decription
     * 
     * @ORM\Column(name="description", type="string", length=500, nullable=true)
     *
     * @Assert\Length(max = "255")
     */
    private $description;

    /**
     * @var string $tags
     *
     * @ORM\Column(name="tags", type="array", nullable=true)
     *
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="\MGP\UserBundle\Entity\User", inversedBy="images", cascade={"remove"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="\MGP\CommentBundle\Entity\Comment", mappedBy="image", cascade={"persist"})
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="images", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
   
    /**
     * @var string $slug
     *
     * @Gedmo\Slug(fields={"title"}, updatable=false, unique=true)
     * @ORM\Column(name="slug", unique=true)
     */
    private $slug;

    /**
     * @Gedmo\Timestampable(on="create")     
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @Assert\DateTime
     */
    protected $pubDate;

    /**
     * @ORM\Column(type="integer", nullable=false)
     *
     */
    protected $status = 1;
    
    /**
     * @var boolean $notify_email
     *
     * @ORM\Column(type="boolean", name="notify_email", nullable=true)
     *
     */
    protected $notify_email;

    /**
     * @var integer $notify_email
     *
     * @ORM\Column(type="integer", name="popularity", nullable=false)
     *
     */
    protected $popularity = 0;

    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/images';
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        $filename = sha1(uniqid(mt_rand(), true));
        $this->path = $filename.'.'.$this->getFile()->guessExtension();
        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        /* if (isset($this->path)) { */
        /*     $this->temp = $this->path; */
        /*     $this->path = null; */
        /* } else { */
        /*     $this->path = 'initial'; */
        /* } */
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }






    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Image
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set tags
     *
     * @param array $tags
     * @return Image
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return array 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Image
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set pubDate
     *
     * @param \DateTime $pubDate
     * @return Image
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;
    
        return $this;
    }

    /**
     * Get pubDate
     *
     * @return \DateTime 
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Image
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set notify_email
     *
     * @param boolean $notifyEmail
     * @return Image
     */
    public function setNotifyEmail($notifyEmail)
    {
        $this->notify_email = $notifyEmail;
    
        return $this;
    }

    /**
     * Get notify_email
     *
     * @return boolean 
     */
    public function getNotifyEmail()
    {
        return $this->notify_email;
    }

    /**
     * Set popularity
     *
     * @param integer $popularity
     * @return Image
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;
    
        return $this;
    }

    /**
     * Get popularity
     *
     * @return integer 
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * Set user
     *
     * @param \MGP\UserBundle\Entity\User $user
     * @return Image
     */
    public function setUser(\MGP\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \MGP\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add comments
     *
     * @param \MGP\CommentBundle\Entity\Comment $comments
     * @return Image
     */
    public function addComment(\MGP\CommentBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \MGP\CommentBundle\Entity\Comment $comments
     */
    public function removeComment(\MGP\CommentBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set category
     *
     * @param \MGP\ImageBundle\Entity\Category $category
     * @return Image
     */
    public function setCategory(\MGP\ImageBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \MGP\ImageBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}