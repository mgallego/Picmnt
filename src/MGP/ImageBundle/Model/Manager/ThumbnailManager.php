<?php

namespace MGP\ImageBundle\Model\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Thubnail Manager
 *
 * @author Moises Gallego <moisesgallego@gmail.com>
 */
class ThumbnailManager
{

    /**
    * @var EntityManager
    */
    protected $em;

    /**
    * @var integer
    */
    protected $imagesPerPage;

    public function __construct(EntityManager $em, $imagesPerPage)
    {
        $this->em = $em;
        $this->imagesPerPage = $imagesPerPage;
    }

    /**
     * Get Thumbnails
     *
     * @param string $category
     * @param string $option
     *
     * @return Object
     */
    public function getThumbnails($category, $option)
    {
        return $this->em->getRepository('MGPImageBundle:Image')
            ->findByCategoryAndOrder(
                $category,
                $this->getOrderField($option),
                null,
                $this->imagesPerPage
            );
    }

    /**
    * Get Order Field
    *
    * @param string $option
    *
    * @return string
    */
    private function getOrderField($option)
    {
        $orderField = 'popularity';
        if ('new' === $option) {
            $orderField = 'id';
        }
        return $orderField;
    }
}
