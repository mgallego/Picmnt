<?php

namespace MGP\ImageBundle\Tests\Controller;

use MGP\MainBundle\Tests\Controller\AbstractControllerTest;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class AjaxControllerTest extends AbstractControllerTest
{
    
    public function testUploadWithAnonUser()
    {
        $this->client->request('GET', '/ajax/images/get_more');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Status 200");
    }
    
}
