<?php

namespace SFM\PicmntBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class AbstractControllerTest extends WebTestCase
{

    protected $client;
    
    public function setUp()
    {
        $this->loadFixtures(
            [
                'MGP\MainBundle\Tests\DataFixtures\ORM\LoadUserImageData',
                'MGP\MainBundle\Tests\DataFixtures\ORM\LoadCategoryData'
            ]
        );

        $this->client = $this->createClient();
    }
}