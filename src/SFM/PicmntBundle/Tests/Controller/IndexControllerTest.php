<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Util\SecureAccess;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{

  public function testIndex()
  {
    $client = $this->createClient();
    
    $crawler = $client->request('GET','/');

    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0);

  }

  
  public function testIndexSecure()
  {

    $secureAccess = new SecureAccess();

    $login = $secureAccess->getData();

    $client = $login["client"];

    $crawler = $login["crawler"];
    
    $crawler = $client->request('GET','/p');
    
    $this->assertTrue($crawler->filter('html:contains("Hello")')->count() > 0);

    return $crawler;

  }
  
}
