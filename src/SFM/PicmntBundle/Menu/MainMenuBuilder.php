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
        die('a');
        $menu = $factory->createItem('main-menu');
        $menu->setChildrenAttribute('class', 'nav');
        
        $imageMenu = $menu->addChild('Explore', array('route' => 'img_show', 'routeParameters' => array('option'=>'recents', 'category'=>'all')));

        return $menu;
    }

}