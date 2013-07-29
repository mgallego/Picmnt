<?php

namespace MGP\ImageBundle\Twig;

use Doctrine\ORM\EntityManager;

class CategoryExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction('getCategories', [$this, 'getCategories']),
        ];
    }

    /**
     * Get categories
     *
     * @return array
     */
    public function getCategories()
    {
        return $this->em->getRepository('MGPImageBundle:Category')->findAll();
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return 'category_extension';
    }
}
