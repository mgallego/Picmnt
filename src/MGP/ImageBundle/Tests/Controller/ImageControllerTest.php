<?php

namespace MGP\ImageBundle\Tests\Controller;

use MGP\MainBundle\Tests\Controller\AbstractControllerTest;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class ImageControllerTest extends AbstractControllerTest
{
    
    public function testUploadWithAnonUser()
    {
        $this->client->request('GET', '/img/upload');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode(), "Status 302");
    }
    
    public function testUploadWithValidUser()
    {
        $client = $this->getLoggedClient();
        $crawler = $client->request('GET', '/img/upload');

        $form = $crawler->selectButton('upload')->form();
        $form['picmnt_image[title]'] = 'Uploaded Image';
        $form['picmnt_image[file]']->upload(realpath(dirname(__FILE__)).'/banner.png');
        $crawler = $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /view/uploaded-image', $crawler->text());
        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $image = $em->getRepository('MGPImageBundle:Image')->findOneBySlug('uploaded-image');

        $this->assertNotNull($image);
    }

    public function testUploadWithoutTitle()
    {
        $client = $this->getLoggedClient();
        $crawler = $client->request('GET', '/img/upload');

        $form = $crawler->selectButton('upload')->form();
        $form['picmnt_image[file]']->upload(realpath(dirname(__FILE__)).'/banner.png');
        $crawler = $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    }

    public function testViewImage()
    {
        $this->client->request('GET', '/view/title-1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Status 200");
    }

    public function testViewFakeImage()
    {
        $this->client->request('GET', '/view/fake-slug');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode(), "Status 404");
    }

    public function testEditImageWhithAnonUser()
    {
        $this->client->request('GET', '/img/edit/1');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode(), "Status 302");
    }

    public function testEditImageWithDifferentUser()
    {
        $client = $this->getLoggedClient('userTest2', 'passwordTest2');
        $client->request('GET', '/img/edit/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /', $client->getResponse()->getContent());
    }

    public function testEditImageWithCorrectUser()
    {
        $client = $this->getLoggedClient();
        $crawler = $client->request('GET', '/img/edit/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");

        $form = $crawler->selectButton('edit-image')->form();
        $form['picmnt_image[description]'] = 'New Description';
        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /view/title-1', $crawler->text());
        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $image = $em->getRepository('MGPImageBundle:Image')->findOneBySlug('title-1');
        $this->assertEquals('New Description', $image->getDescription());
    }

    public function testEditImageWithCorrectUserAndInvalidData()
    {
        $client = $this->getLoggedClient();
        $crawler = $client->request('GET', '/img/edit/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");

        $form = $crawler->selectButton('edit-image')->form();
        $form['picmnt_image[title]'] = null;
        $crawler = $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 302");
    }


}
