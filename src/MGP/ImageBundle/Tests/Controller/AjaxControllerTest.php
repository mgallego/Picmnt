<?php

namespace MGP\ImageBundle\Tests\Controller;

use MGP\MainBundle\Tests\Controller\AbstractControllerTest;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class AjaxControllerTest extends AbstractControllerTest
{

    public function testGetMoreThumbs()
    {
        $imagineMock = $this->getMockBuilder(
            '\Liip\ImagineBundle\Controller\ImagineController'
        )
            ->disableOriginalConstructor()->getMock();

        $this->client->getContainer()->set('liip_imagine.controller', $imagineMock);
        $this->client->request('GET', '/ajax/images/get_more');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Status 200");
    }
}
