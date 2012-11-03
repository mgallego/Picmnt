<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Controller\AbstractControllerTest;

class IndexControllerTest extends AbstractControllerTest
{

    public function testIndexWithAnonymousUser()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertTrue($crawler->filter('html:contains("Join")')->count() > 0, "the URL contains the Picmnt word");

    }

    public function testIndexWithLoggedUser()
    {
        $client = $this->getLoggedClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertFalse($crawler->filter('html:contains("Join")')->count() > 0, "the URL not contain the Join word");
    }

    public function testStaticPage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/static/about');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertTrue($crawler->filter('html:contains("About Us")')->count() > 0, "the URL contains 'About Us'");
    }
}
