<?php

namespace SFM\PicmntBundle\Tests\Controller;

use SFM\PicmntBundle\Tests\Util\SecureAccess;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{

    public function setUp()
    {
        $this->loadFixtures(
            [
                'MGP\MainBundle\Tests\DataFixtures\ORM\LoadUserImageData',
                'MGP\MainBundle\Tests\DataFixtures\ORM\LoadCategoryData'
            ]
        );
    }

    public function testIndex()
    {
        $client = $this->createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}