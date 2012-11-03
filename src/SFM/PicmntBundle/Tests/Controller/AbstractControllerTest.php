<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Util\SecureAccess;
use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{
    public function getLoggedClient()
    {

        $this->loadFixtures(array('SFM\PicmntBundle\Tests\Fixtures\LoadData'));

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
