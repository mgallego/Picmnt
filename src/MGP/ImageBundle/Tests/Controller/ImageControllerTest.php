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

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 302");
    }

}
