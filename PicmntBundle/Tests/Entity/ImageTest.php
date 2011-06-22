<?php

namespace SFM\PicmntBundle\Tests\Entity;

class ImageTest extends \PHPUnit_Framework_TestCase
{

     public function testIdImage()
    {
      $image = $this->getImage();
      $this->assertNull($image->getIdImage());

      $image->setIdImage(1);
      $this->assertEquals(1, $image->getIdImage());
    }

          
/*    public function testUserId()
    {
      $image = $this->getImage();
      $this->assertNull($image->getUserId());

      $image->setUserId(1);
      $this->assertEquals(1, $image->getUserId());
    }
*/
    public function testUrl()
    {
      $image = $this->getImage();
      $this->assertNull($image->getUrl());

      $image->setUrl('URL');
      $this->assertEquals('URL',$image->getUrl());
    }

 
    protected function getImage()
    {
      return $this->getMockForAbstractClass('SFM\PicmntBundle\Entity\Image');
    }

    
}