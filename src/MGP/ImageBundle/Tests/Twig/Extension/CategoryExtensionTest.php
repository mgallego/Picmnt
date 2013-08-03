<?php

namespace MGP\ImageBundle\Tests\Twig\Extension;

use MGP\ImageBundle\Twig\Extension\CategoryExtension;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class CategoryExtensionTest extends WebTestCase
{

    public function testGetFunctions()
    {
        $emMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $categoryExtension = new CategoryExtension($emMock);
        
        $this->assertTrue(is_array($categoryExtension->getFunctions()));
    }
}
