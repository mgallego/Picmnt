<?php

namespace SFM\PicmntBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SFM\PicmntBundle\Tests\Util\SecureAccess;

class ImageControllerTest extends WebTestCase
{

  public function testUpload()
  {

    $secureAccess = new SecureAccess();

    $login = $secureAccess->getData();

    $crawler = $login["crawler"];

    $client = $login["client"];

    $crawler = $client->request('GET','/img/upload');
    
    //print_r($crawler->text());

    $this->assertTrue($crawler->filter('html:contains("insert the URL")')->count() > 0);

  }

}
