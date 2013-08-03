<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Controller\AbstractControllerTest;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class IndexControllerTest extends AbstractControllerTest
{

    public function testStaticPage()
    {
        $this->client->request('GET', '/static/about');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testFakeStaticPage()
    {
        $this->client->request('GET', '/static/fake');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }


    public function testIndexWithNonLogedUser()
    {
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}