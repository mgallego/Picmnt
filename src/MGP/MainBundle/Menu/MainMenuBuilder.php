<?php

namespace MGP\MainBundle\Menu;

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
        $exploreMenu->addChild('Popular', ['route' => 'show_thumbnails', 'routeParameters' => ['option'=>'popular']] );        
        $exploreMenu->addChild('New', ['route' => 'show_thumbnails', 'routeParameters' => ['option'=>'new']] );

        $menu->addChild('Random', ['route' => 'random_image']);
        $menu->addChild('Upload Image', ['route' => 'img_upload']);

        $menu->addChild('divider')->setLabel('')->setAttributes(['class' => 'divider-vertical']);

        return $menu;
    }

    public function loginMenu(FactoryInterface $factory, array $options)
    {
        $securityContext = $this->container->get('security.context');

        $menu = $factory->createItem('login-menu');
        $menu->setChildrenAttribute('class', 'nav pull-right');

        $menu->addChild('divider')->setLabel('')->setAttributes(['class' => 'divider-vertical']);

        if ($securityContext->isGranted('ROLE_USER')) {
            $username = $securityContext->getToken()->getUsername();
            $menu->addChild(ucfirst($username), ['route' => 'usr_profile', 'routeParameters'=> ['userName' => $username]]);
            $menu->addChild('Logout', ['route' => 'fos_user_security_logout']);
        } else {
            $menu->addChild('Login', ['route' => 'fos_user_security_login']);
            $menu->addChild('Sign up', ['route' => 'fos_user_registration_register']);
        }

        return $menu;
    }

}