<?php

namespace SFM\PicmntBundle\Tests\Entity;


use SFM\PicmntBundle\Entity\ImageComment;
use SFM\PicmntBundle\Entity\User;
use SFM\PicmntBundle\Entity\Image;

class ImageCommentTest extends \PHPUnit_Framework_TestCase{
    
    function testIdComment() {
        $imageComment = new ImageComment();
       
        $this->assertNull($imageComment->getIdComment());
        
        $imageComment->setIdComment(1);
        
        $this->assertEquals('1', $imageComment->getIdComment());
        
    }
    
    function testComment() {
        
        $imageComment = new ImageComment();
        
        $this->assertNull($imageComment->getComment());
        
        $imageComment->setComment('comment');
        
        $this->assertEquals('comment', $imageComment->getComment());
        
    }
    
    
    function testUset() {
        
        $imageComment = new ImageComment();
        $user = new User();
        
        
        $this->assertNull($imageComment->getUser());
       
        $imageComment->setUser($user);
        
        $this->assertNotNull($imageComment->getUser());
        
    }

    function testImage() {
        $image = new Image();
        $imageComment = new ImageComment();
        
        $this->assertNull($imageComment->getImage());
        
        $imageComment->setImage($image);
        
        $this->assertnotNull($imageComment->getImage());
        
    }
    
}