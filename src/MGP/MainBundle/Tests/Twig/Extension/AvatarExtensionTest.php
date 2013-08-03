<?php

namespace MGP\MainBundle\Tests\Twig\Extension;

use MGP\MainBundle\Twig\Extension\AvatarExtension;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class CategoryExtensionTest extends WebTestCase
{
    public function testGetFunctions()
    {
        $emMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $avatarExtension = new AvatarExtension($emMock);
        
        $this->assertTrue(is_array($avatarExtension->getFunctions()));
    }
}
