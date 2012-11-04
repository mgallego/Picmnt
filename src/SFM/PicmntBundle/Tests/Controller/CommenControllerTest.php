<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Controller\AbstractControllerTest;

class CommentControllerTest extends AbstractControllerTest
{

    public function testCreateCommentWithAnonUser()
    {
        $client = $this->createClient();
        $crawler = $client->request('POST', '/comment/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('/login', $crawler->text());
    }

    public function testCommentWithAuthenticatedUser()
    {
        $params = [
            'comment' => 'testComment2'
        ];
            
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('POST', '/comment/1', $params);
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 200");
        $this->assertContains('Redirecting to /view/userTest/title_1', $crawler->text());
    }

    public function testDeleteCommentWithAnonUser()
    {
        $client = $this->createClient();
        $crawler = $client->request('POST', '/comment/delete/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('/login', $crawler->text());
    }

    public function testDeleteCommentWithDifferentUser()
    {
        $client = $this->getLoggedClient('userTest2', 'passwordTest2');
        $crawler = $client->request('POST', '/comment/delete/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /', $crawler->text());
    }

    public function testDeleteWithOwnerUser()
    {
        $client = $this->getLoggedClient('userTest', 'passwordTest');
        $crawler = $client->request('POST', '/comment/delete/1');
        $this->assertEquals(302, $client->getResponse()->getStatusCode(), "Status 302");
        $this->assertContains('Redirecting to /view/userTest/title_1', $crawler->text());
    }
}
