<?php
namespace SFM\PicmntBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder
{

  private $factory;

  /**
   * @param FactoryInterface $factory
   */
  public function __construct(FactoryInterface $factory)
  {
    $this->factory = $factory;
  }


  public function createMenuLogin(Request $request)
  {
    $menu = $this->factory->createItem('root');
    $menu->setCurrentUri($request->getRequestUri());
    $menu->setAttribute('class', 'pills'); 


    $menu->addChild('Sign Up', array('route' => 'fos_user_registration_register'));
    $menu->addChild('Login', array('route' => 'fos_user_security_login'));


    return $menu;
  }

  public function createMenuTabs(Request $request)
  {
    $menu = $this->factory->createItem('root');
    $menu->setCurrentUri($request->getRequestUri());
    $menu->setAttribute('class', 'tabs'); 
    $menu->setAttribute('style','align: right');

    $menu->addChild('Random', array('route' => 'img_show', 'routeParameters' => array('option'=>'random')));
    $menu->addChild('Last', array('route' => 'img_show', 'routeParameters' => array('option'=>'last')));
    $menu->addChild('My Profile', array('route' => 'home'));
    $menu->addChild('Upload Images', array('route' => 'img_upload'));
    $menu->addChild('Admin', array('route' => 'home'));
    

    $menu->addChild('prueba', array('route' => 'home'));
    return $menu;
  }

}