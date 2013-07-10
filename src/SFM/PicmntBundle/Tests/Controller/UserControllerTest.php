<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Controller\AbstractControllerTest;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserControllerTest extends AbstractControllerTest
{

    public function testShowInvalidProfile()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/profile/fake_user');
        $this->assertEquals(404, $client->getResponse()->getStatusCode(), "Status 404");
    }

    public function testShowActualProfile()
    {
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/profile');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    }

    public function testShowProfile()
    {
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/profile/userTest');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 200");
    }

    public function estShowPendingOfFakeUser()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/pending/fake_user');
        $this->assertEquals(404, $client->getResponse()->getStatusCode(), "Status 404");
    }

    public function testShowPendingOfDifferentUser()
    {
        $client = $this->getLoggedClient('userTest2', 'passwordTest2');
        $crawler = $client->request('GET', '/pending/userTest');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 404");
        $this->assertContains('Redirecting to /all/random', $crawler->text());
    }

    public function testShowOwnerPendingAction()
    {
        $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/pending/userTest');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 404");
    }

    public function testEditProfile()
    {
         $this->markTestIncomplete(
          'This test has not been implemented yet.'
        );
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('GET', '/profile/userTest');

        $form = $crawler->selectButton('form-edit-profile-submit')->form();
        $form['form[avatar]']->upload(realpath(dirname(__FILE__)).'/banner.png');
        $crawler = $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Status 404");
    }
    
}
