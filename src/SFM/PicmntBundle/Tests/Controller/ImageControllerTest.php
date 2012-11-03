<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Controller\AbstractControllerTest;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageControllerTest extends AbstractControllerTest
{
    
    public function testUploadWithAnonUser()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/img/upload');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 200");
    }

    public function testUploadWithValidUser()
    {
        $image = new UploadedFile(
            realpath(dirname(__FILE__)).'/banner.png',
            'photo.png',
            'image/png',
            123
        );
        
        $client = $this->getLoggedClient();
        $crawler = $client->request('GET', '/img/upload');

        if (200 !== $client->getResponse()->getStatusCode()) {
            echo '<pre>';
            var_dump($crawler->text());
            echo '<pre>';
        }

        $form = $crawler->selectButton('upload')->form();
        $form['picmnt_image_imageuptype[dataFile]']->upload(realpath(dirname(__FILE__)).'/banner.png');
        $crawler = $client->submit($form);

        if (200 !== $client->getResponse()->getStatusCode()) {
            echo '<pre>';
            var_dump($crawler->text());
            echo '<pre>';
        }
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");
    }

    /* public function testGetRandomImage() */
    /* { */

    /*     $client = $this->createClient(); */
    /*     $crawler = $client->request('GET', '/all/random'); */
    /*     $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200"); */

    /*     $secureAccess = new SecureAccess(); */
    /*     $client = $secureAccess->getClient(); */
    /*     $crawler = $client->request('GET', '/all/random'); */
    /*     $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200"); */
    /*     $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word"); */
    /* } */

    /* public function testImageAction() */
    /* { */
    /*     $secureAccess = new SecureAccess(); */
    /*     $client = $secureAccess->getClient(); */
    /*     $crawler = $client->request('GET', '/img/show3/last'); */
    /*     $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200"); */
    /*     $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word"); */
    /* } */

    /* public function testGetImageAction() */
    /* { */
    /*     $client = $this->createClient(); */
    /*     $crawler = $client->request('GET', '/all/last'); */
    /*     $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200"); */

    /*     $secureAccess = new SecureAccess(); */
    /*     $client = $secureAccess->getClient(); */
    /*     $crawler = $client->request('GET', '/all/last'); */
    /*     $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word"); */

    /*     $crawler = $client->request('GET', '/all/last/fakenumber'); */
    /*     $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word"); */

    /*     $crawler = $client->request('GET', '/all/last/999'); */
    /*     $this->assertTrue($crawler->filter('html:contains("title_10")')->count() > 0, "Finding an error image"); */

    /*     $crawler = $client->request('GET', '/all/last/3'); */
    /*     $this->assertTrue($crawler->filter('html:contains("title_3")')->count() > 0, "Finding an Image"); */

    /*     $link = $crawler->selectLink('Previous')->link(); */
    /*     $crawler = $client->click($link); */
    /*     $this->assertTrue($crawler->filter('html:contains("title_2")')->count() > 0, "Previous Image"); */

    /*     $link = $crawler->selectLink('Next')->link(); */
    /*     $crawler = $client->click($link); */
    /*     $this->assertTrue($crawler->filter('html:contains("title_3")')->count() > 0, "Next Image"); */

    /*     //    echo $crawler->text(); */
    /* } */
}
