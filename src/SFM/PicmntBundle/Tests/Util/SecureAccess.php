<?php

namespace SFM\PicmntBundle\Tests\Util;

//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class SecureAccess extends WebTestCase
{

  public function getClient()
  {

    echo 'entrando por aquií';

    $this->loadFixtures(array('SFM\PicmntBundle\Tests\Fixtures\LoadUserData'));

    $client = $this->createClient();

    $crawler = $client->request('GET','/logout');
    
    $crawler = $client->request('GET','/login');

    $form = $crawler->selectButton('login')->form();

    $form['_username'] = 'moises';
    $form['_password'] = 'password';

    $crawler = $client->submit($form);
    
    return $client;

  }

}