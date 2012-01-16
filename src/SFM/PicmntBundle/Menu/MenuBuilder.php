<?php
namespace SFM\PicmntBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Security\Core\SecurityContext;

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


  public function createMenuLogin(Request $request, Translator $translator)
  {
    $menu = $this->factory->createItem('root');
    $menu->setCurrentUri($request->getRequestUri());
    $menu->setAttribute('class', 'pills'); 


    $menu->addChild($translator->trans('Join'), array('route' => 'fos_user_registration_register'));
    $menu->addChild($translator->trans('Login'), array('route' => 'fos_user_security_login'));


    return $menu;
  }

  public function createMenuTabs(Request $request, Translator $translator, SecurityContext $context)
  {
    $menu = $this->factory->createItem('root');
    $menu->setCurrentUri($request->getRequestUri());
    $menu->setAttribute('class', 'tabs'); 
    $menu->setAttribute('style','align: right');

    $category = $request->get('category');
    
    if (!$category){
	$category = 0;
    }

    $menu->addChild($translator->trans('Random'), array('route' => 'img_show', 'routeParameters' => array('option'=>'random', 'category'=>$category)));
    $menu->addChild($translator->trans('Last'), array('route' => 'img_show', 'routeParameters' => array('option'=>'last', 'category'=>$category)));
    
    if ($context->isGranted('ROLE_USER')){

    $menu->addChild($translator->trans('My Profile'), array('route' => 'home'));
    $menu->addChild($translator->trans('Upload Image'), array('route' => 'img_upload'));
    $menu->addChild($translator->trans('Admin'), array('route' => 'home'));
    }
    return $menu;
  }





}