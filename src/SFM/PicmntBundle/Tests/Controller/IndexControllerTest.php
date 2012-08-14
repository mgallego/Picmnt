<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Util\SecureAccess;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase {

  public function testIndex() {

    $client = $this->createClient();
    $crawler = $client->request('GET', '/');
    $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");

  }

  public function testIndexSecure() {

    $secureAccess = new SecureAccess();
    
    $client = $secureAccess->getClient();
    $crawler = $client->request('GET', '/all/random');
    //print_r($crawler->text());
    $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0);
  }

}
