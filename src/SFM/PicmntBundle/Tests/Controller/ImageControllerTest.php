<?php

namespace SFM\PicmntBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SFM\PicmntBundle\Tests\Util\SecureAccess;

class ImageControllerTest extends WebTestCase
{

  public function testUpload()
  {

    $client = $this->createClient();
    $crawler = $client->request('GET', '/img/upload');
    $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 200");


    $secureAccess = new SecureAccess();
    $client = $secureAccess->getClient();
    $crawler = $client->request('GET','/img/upload');
    $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");

  }

  public function testGetRandomImage(){

    $client = $this->createClient();
    $crawler = $client->request('GET', '/img/random');
    $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 200");


    $secureAccess = new SecureAccess();
    $client = $secureAccess->getClient();
    $crawler = $client->request('GET', '/img/random');
    $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");

  }

  public function testImageAction(){

    /*    $secureAccess = new SecureAccess();
    $client = $secureAccess->getClient();
    $crawler = $client->request('GET', '/img/show3/last');
    $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");
    */
  }

  public function testGetImageAction(){
    
    $client = $this->createClient();
    $crawler = $client->request('GET', '/img/show/last');
    $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 200");

    $secureAccess = new SecureAccess();
    $client = $secureAccess->getClient();
    $crawler = $client->request('GET', '/img/show/last');
    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");

    $crawler = $client->request('GET', '/img/show/last/fakenumber');
    $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");

    $crawler = $client->request('GET', '/img/show/last/999');
    $this->assertTrue($crawler->filter('html:contains("title_10")')->count() > 0, "Finding an error image");

    
    $crawler = $client->request('GET','/img/show/last/3');
    $this->assertTrue($crawler->filter('html:contains("title_3")')->count() > 0, "Finding an Image");
    

    $link = $crawler->selectLink('Previous')->link();
    $crawler = $client->click($link);
    $this->assertTrue($crawler->filter('html:contains("title_2")')->count() > 0, "Previous Image");

    $link = $crawler->selectLink('Next')->link();
    $crawler = $client->click($link);
    $this->assertTrue($crawler->filter('html:contains("title_3")')->count() > 0, "Next Image");


    //    echo $crawler->text();
 
  }


}
