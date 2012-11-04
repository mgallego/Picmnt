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
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('/login', $crawler->text());
    }

    public function testUploadWithValidUser()
    {
        $image = new UploadedFile(
            realpath(dirname(__FILE__)).'/banner.png',
            'photo.png',
            'image/png',
            123
        );
        
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/img/upload');

        $form = $crawler->selectButton('upload')->form();
        $form['picmnt_image_imageuptype[dataFile]']->upload(realpath(dirname(__FILE__)).'/banner.png');
        $crawler = $client->submit($form);
        
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /img/edit/11', $crawler->text());
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $image = $em->getRepository('SFMPicmntBundle:Image')->findOneByTitle('banner');

        $this->assertNotNull($image);
    }

    public function testEditImageAnonUser()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/img/edit/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /all/show/1', $crawler->text());
    }

    public function testEditImageWithDifferentUser()
    {
        $client = $this->getLoggedClient('userTest2', 'passwordTest2');
        $crawler = $client->request('GET', '/img/edit/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /all/show/1', $crawler->text());
    }
    
    public function testEditImageWithOwnerUser()
    {
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/img/edit/2');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $form = $crawler->selectButton('edit-image')->form();
        $form['picmnt_image_imagetype[title]'] = 'editedTitle';
        $crawler = $client->submit($form);
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $image = $em->getRepository('SFMPicmntBundle:Image')->findOneByIdImage(2);
        $this->assertEquals('editedTitle', $image->getTitle());
    }

    public function testDeleteImageWithAnonUser()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/img/delete/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /all/show/1', $crawler->text());
    }

    public function testDeleteImageWithDifferentUser()
    {
        $client = $this->getLoggedClient('userTest2', 'passwordTest2');
        $crawler = $client->request('GET', '/img/delete/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /all/show/1', $crawler->text());
    }

    public function testDeleteImageWithOwnerUser()
    {
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/img/delete/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /profile/userTest', $crawler->text());
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $image = $em->getRepository('SFMPicmntBundle:Image')->findOneByIdImage(1);
        $this->assertEquals(2, $image->getStatus());
    }

    public function testViewImageWithAnonUser()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/view/userTest/title_1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertTrue($crawler->filter('h1:contains("title_1")')->count() > 0, "the URL containt the title");
    }   


    public function testViewImageWithDiferentUser()
    {
        $client = $this->getLoggedClient('userTest2', 'passwordTest2');
        $crawler = $client->request('GET', '/view/userTest/title_1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertTrue($crawler->filter('h1:contains("title_1")')->count() > 0, "the URL containt the title");
    }   

    public function testViewImageWithOwnerUser()
    {
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/view/userTest/title_1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertTrue($crawler->filter('h1:contains("title_1")')->count() > 0, "the URL containt the title");
    }   

    public function testViewImageWithAnInvalidSlug()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/view/userTest/fake_slug');
        $this->assertEquals(404, $client->getResponse()->getStatusCode(), "Status 200");
    }   

    
    public function testGetRandomImage()
    {

        $client = $this->createClient();
        $crawler = $client->request('GET', '/all/random');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");

        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/all/random');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");
    }

    public function testRecentsImage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/all/recents');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertTrue($crawler->filter('h1:contains("Recents")')->count() > 0, "the URL contains the Recents word");
    }


    public function testShowImage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/all/show/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertTrue($crawler->filter('h1:contains("title_1")')->count() > 0, "the URL containt the title");
    }

    public function testGetImageOrderAction()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/all/last');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");

        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/all/last');
        $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");

        $crawler = $client->request('GET', '/all/last/fakenumber');
        $this->assertTrue($crawler->filter('html:contains("Picmnt")')->count() > 0, "the URL contains the Picmnt word");

        $crawler = $client->request('GET', '/all/last/999');
        $this->assertTrue($crawler->filter('html:contains("title_10")')->count() > 0, "Finding an error image");

        $crawler = $client->request('GET', '/all/last/3');
        $this->assertTrue($crawler->filter('html:contains("title_3")')->count() > 0, "Finding an Image");

        $link = $crawler->selectLink('Previous')->link();
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('html:contains("title_2")')->count() > 0, "Previous Image");

        $link = $crawler->selectLink('Next')->link();
        $crawler = $client->click($link);
        $this->assertTrue($crawler->filter('html:contains("title_3")')->count() > 0, "Next Image");
    }
}
