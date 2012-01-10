<?php
namespace SFM\PicmntBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{

  private $factory;

  /**
   * @param FactoryInterface $factory
   
  public function __construct(FactoryInterface $factory)
  {
    $this->factory = $factory;
  }
  */

  public function menuPrincipal(FactoryInterface $factory)
  {
    $menu = $factory->createItem('root');
    $menu->setCurrentUri($this->container->get('request')->getRequestUri());

    $menu->addChild('Sign Up', array('route' => 'fos_user_registration_register'));
    $menu->addChild('Login', array('route' => 'fos_user_security_login'));
    
    $prueba = $this->container->get('request');

    return $menu;
  }

  public function menuCategories(FactoryInterface $factory)
  {

    $menu = $factory->createItem('root');

    $menu->setCurrentUri($this->container->get('request')->getRequestUri());
    $menu->setAttribute('class', 'nav');     
    $em = $this->container->get('doctrine')->getEntityManager();

    $categories = $em->getRepository('SFMPicmntBundle:Category')->findAll();
    
    
    $menu->addChild($this->container->get('translator')->trans('All'), array('route' => 'fos_user_registration_register'));

    foreach ($categories as $category)
    {
      $menu->addChild($this->container->get('translator')->trans($category->getName()), array('route' => 'fos_user_registration_register'));
    }

    return $menu;
  }

}