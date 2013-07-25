<?php

namespace SFM\PicmntBundle\Model\Manager;

use SFM\PicmntBundle\Model\Type\ThumbType;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

/**
* ThumbManager
*
* @author Moises Gallego <moisesgallego@gmail.com>
* @copyright Moises Gallego 2013
*/
class ThumbManager
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
    public function __construct(EntityManager $em, Translator $translator, Router $router, $imagesPerPage, CacheManager $imagineCacheManager)
    {
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
    public function getMoreThumbs(Request $request, \Liip\ImagineBundle\Controller\ImagineController $imagemanagerResponse )
    {
        $serializeImages = [];
        
        $page = $request->query->get('page');
        $category = $request->query->get('category');
        $username = $request->query->get('username');
        $option = $request->query->get('option');
        $username = $request->query->get('username');
        
        switch ($option) {
            case 'recents':
                $images = $this->em->getRepository('SFMPicmntBundle:Image')
                    ->findByCategoryAndOrder($category, 'idImage',  $page * $this->imagesPerPage, $this->imagesPerPage);
                break;
            case 'popular':
                $images = $this->em->getRepository('SFMPicmntBundle:Image')
                    ->findByCategoryAndOrder($category, 'popularity',  $page * $this->imagesPerPage, $this->imagesPerPage);
                break;
            case 'profile':
                $images = $this->em->getRepository('SFMPicmntBundle:Image')
                    ->getByUsername($username, $page * $this->imagesPerPage, $this->imagesPerPage);
                break;
        }
                
        if ($images) {
            foreach ($images as $image) {
                $user = $image->getUser();
                $thumb = new ThumbType();
                
                $imagemanagerResponse->filterAction(
                        $request,
                        'uploads/'.$image->getUrl(),      // original image you want to apply a filter to
                        'thumbnail'              // filter defined in config.yml
                    );
                
                $thumb->setSlug($image->getSlug());
                $thumb->setImageId($image->getIdImage());
                $thumb->setTitle(substr($image->getTitle(),0,20));
                $thumb->setUrl($this->imagineCacheManager->getBrowserPath('/uploads/'.$image->getUrl(), 'thumbnail'));
                $thumb->setImageViewUrl(
                    $this->router->generate('img_view',
                        [
                            'user' => $user->getUsername(),
                            'slug' => $thumb->getSlug()
                        ]
                    )
                );
                $thumb->setCategory($image->getCategory());
                $thumb->setAuthorLabel($this->translator->trans('By'));
                $thumb->setUserId($user->getId());
                $thumb->setUsername(substr($user->getUsername(),0,20));
                $thumb->setUserUrl(
                    $this->router->generate('usr_profile',
                        [
                            'userName' => $image->getUser()->getUsername()
                        ]
                    )
                );
                
                $serializeImages[] = $thumb->toArray();
            }
        }

        return $serializeImages;
    }
    
}