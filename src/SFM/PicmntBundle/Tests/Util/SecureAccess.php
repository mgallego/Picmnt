<?php

namespace SFM\PicmntBundle\Tests\Util;

//use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class SecureAccess extends WebTestCase
{
    public function getClient()
  {

    $this->loadFixtures(array('SFM\PicmntBundle\Tests\Fixtures\LoadData'));

    $client = $this->createClient();

    $crawler = $client->request('GET','/logout');
    
    $crawler = $client->request('GET','/login');

    $form = $crawler->selectButton('login')->form();
    
    $form['_username'] = 'userTest';
    $form['_password'] = 'passwordTest';
    
    $crawler = $client->submit($form);
    
    return $client;

  }


}