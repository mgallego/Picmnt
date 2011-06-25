<?php

namespace SFM\PicmntBundle\Tests\Entity;

use SFM\PicmntBundle\Entity\UserInfo;
use SFM\PicmntBundle\Entity\User;

class UserInfoTest extends \PHPUnit_Framework_TestCase {

    public function testUserId() {
        $userInfo = $this->getUserInfo();
        $this->assertNull($userInfo->getUserId());

        $userInfo->setUserId(1);
        $this->assertEquals(1, $userInfo->getUserId());
    }

    public function testName() {
        $userInfo = $this->getUserInfo();
        $this->assertNull($userInfo->getName());

        $userInfo->setName('UserName');
        $this->assertEquals('UserName', $userInfo->getName());
    }

    public function tesLastName() {
        $userInfo->$this->getUserInfo();
        $this->assertNull($userInfo->getLastName());

        $userInfo->setLastName('LastName');
        $this->assertEquals('LastName', $userInfo->getLastName());
    }

    function testAvatar() {

        $userInfo = new UserInfo();

        $this->assertNull($userInfo->getAvatar());

        $userInfo->setAvatar('Avatar');

        $this->assertEquals('Avatar', $userInfo->getAvatar());
    }

    function testUser(){
        
        $userInfo = new UserInfo();
        
        $this->assertNull($userInfo->getUser());
        
        $user = new User();
        
        $userInfo->setUser($user);
        
        $this->assertNotNull($userInfo->getUser());
        
    }
    
    protected function getUserinfo() {
        return $this->getMockForAbstractClass('SFM\PicmntBundle\Entity\UserInfo');
    }

}