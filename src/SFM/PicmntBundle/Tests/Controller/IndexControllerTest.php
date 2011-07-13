<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Util\SecureAccess;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use SFM\PicmntBundle\DataFixtures\ORM\LoadUserData;

class IndexControllerTest extends WebTestCase {

  public function testIndex() {

    $client = $this->createClient();
    $crawler = $client->request('GET', '/');
    $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");
  }

  public function testIndexSecure() {

    $loadUserData = new LoadUserData();

    $loadUserData->load($this->get('doctrine')->getEntityManager());

    $secureAccess = new SecureAccess();
    $client = $secureAccess->getClient();
    $crawler = $client->request('GET', '/img/random');
    $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0);
  }

}
