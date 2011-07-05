<?php

namespace SFM\PicmntBundle\Tests\Entity;

use SFM\PicmntBundle\Entity\Image;
use SFM\PicmntBundle\Entity\User;
use SFM\PicmntBundle\Entity\ImageComment;

class ImageTest extends \PHPUnit_Framework_TestCase {

    public function testIdImage() {
        $image = $this->getImage();
        $this->assertNull($image->getIdImage());

        $image->setIdImage(1);
        $this->assertEquals(1, $image->getIdImage());
    }

    public function testUserId() {
        $image = new Image();
        $user = new User();

        $this->assertNull($image->getUser());

        $user->setUsername('aa');

        $image->setUser($user);

        $this->assertEquals('aa', $image->getUser()->getUsername());
    }

    public function testUrl() {
        $image = $this->getImage();
        $this->assertNull($image->getUrl());

        $image->setUrl('URL');
        $this->assertEquals('URL', $image->getUrl());
    }

    function testTitle() {
        $image = new Image();

        $this->assertNull($image->getTitle());

        $image->setTitle('title');
        $this->assertEquals('title', $image->getTitle());
    }

    function testDescription() {
        $image = new Image();

        $this->assertNull($image->getDescription());


        $image->setDescription('description');
        $this->assertEquals('description', $image->getDescription());
    }

    function testCategory() {
        $image = new Image();

        $this->assertNull($image->getCategory());

        $image->setCategory(1);

        $this->assertEquals(1, $image->getCategory());
    }

    function testTags() {
        $image = new Image();

        $this->assertNull($image->getTags());

        $image->setTags('tag1');
        $this->assertEquals('tag1', $image->getTags());
    }

    function testVotes() {
        $image = new Image();

        $this->assertNull($image->getVotes());

        $image->setVotes(1);

        $this->assertEquals(1, $image->getVotes());
    }

    function testUserVotes() {
        $image = new Image();
        $user = new User();

        $this->assertNull($image->getUserVotes());

        $user = new User();
        $image->addUserVotes($user);

        $this->assertNotNull($image->getUserVotes());
    }

    function testImageComments() {
        $image = new Image();
        $imageComment = new ImageComment();

        $this->assertNull($image->getImageComments());

        $image->addImageComments($imageComment);

        $this->assertNotNull($image->getImageComments());
    }

    protected function getImage() {
        return $this->getMockForAbstractClass('SFM\PicmntBundle\Entity\Image');
    }

}