<?php

namespace MGP\ImageBundle\Model\Manager;

use MGP\ImageBundle\Model\Type\ThumbType;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Thubnail Manager
 *
 * @author Moises Gallego <moisesgallego@gmail.com>
 */
class ThumbnailManager
{

    protected $em;

    protected $translator;

    protected $router;

    protected $imagesPerPage;

    protected $imagineCacheManager;

    /**
     * __construct
     * 
     * @param EntityManager $em
     * @param Translator $translator
     * @param Route $router
     * @param $imagesPerPage
     * @param CacheManager $imagineCacheManager
     */
    public function __construct(
        EntityManager $em,
        Translator $translator,
        Router $router,
        $imagesPerPage,
        CacheManager $imagineCacheManager
    ) {
        $this->em = $em;
        $this->translator = $translator;
        $this->router = $router;
        $this->imagesPerPage = $imagesPerPage;
        $this->imagineCacheManager = $imagineCacheManager;
    }

    /**
     * getMoreThumbs
     * 
     * @param array $params
     */
    public function getMoreThumbs(
        Request $request,
        \Liip\ImagineBundle\Controller\ImagineController $imagemanagerResponse
    ) {
        $serializeImages = [];

        $page = $request->query->get('page');
        $category = $request->query->get('category');
        $option = $request->query->get('option');

        $images = $this->getThumbnails($category, $option, $page * $this->imagesPerPage);
        
        if ($images) {
            foreach ($images as $image) {
                $user = $image->getUser();
                $thumb = new ThumbType();
                
                $imagemanagerResponse->filterAction(
                    $request,
                    $image->getWebPath(),
                    'thumbnail'
                );
                
                $thumb->setSlug($image->getSlug());
                $thumb->setImageId($image->getId());
                $thumb->setTitle(substr($image->getTitle(), 0, 20));
                $thumb->setUrl($this->imagineCacheManager->getBrowserPath($image->getWebPath(), 'thumbnail'));
                $thumb->setImageViewUrl(
                    $this->router->generate(
                        'img_view',
                        ['user' => $user->getUsername(),
                            'slug' => $thumb->getSlug()]
                    )
                );
                $thumb->setCategory($image->getCategory());
                $thumb->setAuthorLabel($this->translator->trans('By'));
                $thumb->setUserId($user->getId());
                $thumb->setUsername(substr($user->getUsername(), 0, 20));
                $thumb->setUserUrl(
                    $this->router->generate(
                        'usr_profile',
                        ['userName' => $image->getUser()->getUsername()]
                    )
                );
                
                $serializeImages[] = $thumb->toArray();
            }
        }

        return $serializeImages;
    }

    /**
     * Get Thumbnails
     *
     * @param string $category
     * @param string $option
     *
     * @return Object
     */
    public function getThumbnails($category, $option, $offset = null)
    {
        return $this->em->getRepository('MGPImageBundle:Image')
            ->findByCategoryAndOrder(
                $category,
                $this->getOrderField($option),
                $offset,
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
