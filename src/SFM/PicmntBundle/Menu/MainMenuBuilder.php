<?php

namespace SFM\PicmntBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
* MainMenuBuilder
*
* @author Moises Gallego <moisesgallego@gmail.com>
*/ 
class MainMenuBuilder extends ContainerAware
{

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('main-menu');
        $menu->setChildrenAttribute('class', 'nav');

        $exploreMenu = $menu->addChild('Explore', ['uri' => ' '])
            ->setLinkAttributes(
                [
                    'class' => 'dropdown-toggle',
                    'data-toggle' => 'dropdown',
                ]
            )
            ->setLabel('Explore <b class="caret"></b>')
            ->setExtra('safe_label', true);

        $exploreMenu->setChildrenAttributes(['class' => 'dropdown-menu', 'role' => 'menu']);
        $exploreMenu->addChild('recents', ['route' => 'img_show', 'routeParameters' => ['option'=>'recents', 'category'=>'all']] );
        $exploreMenu->addChild('popular', ['route' => 'img_show', 'routeParameters' => ['option'=>'recents', 'category'=>'all']] );        

        $randomMenu = $menu->addChild('Random', ['route' => 'img_show', 'routeParameters' => ['option'=>'random', 'category'=>'all']]);
        $uploadMenu = $menu->addChild('Upload Image', ['route' => 'img_upload']);
        
        return $menu;
    }

}