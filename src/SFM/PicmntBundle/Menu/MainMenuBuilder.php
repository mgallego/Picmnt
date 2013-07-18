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
        $exploreMenu->setChildrenAttribute('class', 'dropdown-menu');
        $exploreMenu->addChild('aaaa')->setExtra('safe_label', true);
        $exploreMenu->addChild('b');
        //$exploreMenu = $menu->addChild('Explore', array('route' => 'img_show', 'routeParameters' => array('option'=>'recents', 'category'=>'all')));

        

        
        return $menu;
    }

}