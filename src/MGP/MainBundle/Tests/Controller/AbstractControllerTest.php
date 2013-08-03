<?php

namespace MGP\MainBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{

    protected $client;
    
    public function setUp()
    {
        $this->loadFixtures(
            [
                'MGP\MainBundle\Tests\DataFixtures\ORM\LoadUserImageData',
                'MGP\ImageBundle\DataFixtures\ORM\LoadCategoryData'
            ]
        );

        $this->client = $this->createClient();
    }

    public function getLoggedClient($username = 'userTest', $password = 'passwordTest')
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/logout');
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = $username;
        $form['_password'] = $password;
        $crawler = $client->submit($form);
        return $client;
    }
}