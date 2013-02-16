<?php
namespace SFM\PicmntBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{

    public function menuCategories(FactoryInterface $factory)
    {

        $menu = $factory->createItem('root');

        $menu->setCurrentUri($this->container->get('request')->getRequestUri());
        $menu->setAttribute('class', 'submenu unstyled');     
        $em = $this->container->get('doctrine')->getEntityManager();

        $categories = $em->getRepository('SFMPicmntBundle:Category')->findAll();

        $request = $this->container->get('request');
        $option = $request->get('option');
        $idImage = $request->get('idImage');

        if (!$option){
            $option  = 'recents';
        }

        $menu->addChild(
            $this->container->get('translator')->trans('All'),
            [
                'route' => 'img_show',
                'routeParameters'=> [
                    'option' => $option,
                    'idImage' => $idImage,
                    'category'=>'all'
                ]
            ]
        );
        foreach ($categories as $category)
            {
                $menu->addChild(
                    $this->container->get('translator')->trans(ucwords($category->getName())),
                    [
                        'route' => 'img_show',
                        'routeParameters' => [
                            'option' => $option,
                            'idImage' => $idImage,
                            'category'=>$category->getName()
                        ]
                    ]
                );
            }

        return $menu;

    }

}