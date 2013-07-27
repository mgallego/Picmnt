<?php

namespace MGP\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MGPUserBundle extends Bundle
{
    public function getParent(){
        return 'FOSUserBundle';
    }
}
