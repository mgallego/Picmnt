<?php

namespace SFM\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SFMUserBundle extends Bundle
{

  public function getParent(){
    return 'FOSUserBundle';
  }

}
