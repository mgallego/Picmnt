<?php
namespace SFM\PicmntBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class MenuBuilder extends ContainerAware
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

  public function createMenuTabs(Request $request, Translator $translator)
  {
    $menu = $this->factory->createItem('root');
    $menu->setCurrentUri($request->getRequestUri());
    $menu->setAttribute('class', 'tabs'); 
    $menu->setAttribute('style','align: right');

    $menu->addChild($translator->trans('Random'), array('route' => 'img_show', 'routeParameters' => array('option'=>'random')));
    $menu->addChild($translator->trans('Last'), array('route' => 'img_show', 'routeParameters' => array('option'=>'last')));
    $menu->addChild($translator->trans('My Profile'), array('route' => 'home'));
    $menu->addChild($translator->trans('Upload Image'), array('route' => 'img_upload'));
    $menu->addChild($translator->trans('Admin'), array('route' => 'home'));

    $e = $translator->trans('prueba');
    return $menu;
  }





}