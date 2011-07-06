<?php 

namespace SFM\PicmntBundle\Menu;

use Knp\Bundle\MenuBundle\Menu;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

class MainMenu extends Menu{

  /**
   * @param Request $request
   * @param Router $router
   */
  public function __construct(Request $request, Router $router)
  {
    parent::__construct();

    $this->setCurrentUri($request->getRequestUri());

    $this->addChild('Home', $router->generate('home'));
    $this->addChild('Random Image', $router->generate('img_random'));
    $this->addChild('Lastest Upload', $router->generate('img_show', array('selection'=>'last')));
    $this->addChild('Upload Image', $router->generate('img_upload'));
    //    $this->addChild('Home', $router->generate('home'));
    //    $this->addChild('Home', $router->generate('home'));
    // ... add more children
  }


}
