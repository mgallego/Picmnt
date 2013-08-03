<?php

namespace MGP\ImageBundle\Tests\Controller;

use MGP\MainBundle\Tests\Controller\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Request;

class ThumbnailManagerTest extends AbstractControllerTest
{

    public function testGetMoreThumbs()
    {
        $this->assertEquals(10, count($this->getPaginatedThums(0)));
    }

    public function testGetMoreThumbsWithPageExceed()
    {
        $this->assertEquals(0, count($this->getPaginatedThums(1)));        
    }

    private function getPaginatedThums($page)
    {
        $request = new Request();
        $request->initialize(['page' => $page]);

        $imagineMock = $this->getMockBuilder(
            '\Liip\ImagineBundle\Controller\ImagineController'
        )
            ->disableOriginalConstructor()->getMock();
        
        return $this->getContainer()
            ->get('mgp.image.thumbnail_manager')
            ->getMoreThumbs(
                $request,
                $imagineMock
            );
    }
}
