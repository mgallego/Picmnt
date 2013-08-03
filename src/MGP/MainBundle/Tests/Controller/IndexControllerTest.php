<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Util\SecureAccess;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{

    private $client;
    
    public function setUp()
    {
        $this->loadFixtures(
            [
                'MGP\MainBundle\Tests\DataFixtures\ORM\LoadUserImageData',
                'MGP\MainBundle\Tests\DataFixtures\ORM\LoadCategoryData'
            ]
        );

        $this->client = $this->createClient();
    }

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