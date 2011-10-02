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
}