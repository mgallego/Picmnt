<?php

namespace SFM\PicmntBundle\Tests\Controller;

use MGP\MainBundle\Tests\Controller\AbstractControllerTest;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class ExploreControllerTest extends AbstractControllerTest
{
    public function testPopularWithNonLogedUser()
    {
        $this->client->request('GET', '/popular');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testNewWithNonLogedUser()
    {
        $this->client->request('GET', '/new');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testRandomWithNonLogedUser()
    {
        $this->client->request('GET', '/random');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}