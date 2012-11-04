<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Util\SecureAccess;
use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures(
            [
                'SFM\PicmntBundle\Tests\DataFixtures\ORM\LoadUserImageData',
                'SFM\PicmntBundle\Tests\DataFixtures\ORM\LoadCategoryData'
            ]
        );
    }

    public function getLoggedClient()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/logout');
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('login')->form();
        $form['_username'] = 'userTest';
        $form['_password'] = 'passwordTest';
        $crawler = $client->submit($form);
        return $client;
    }
}
