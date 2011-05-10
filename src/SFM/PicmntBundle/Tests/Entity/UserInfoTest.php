<?php

namespace SFM\PicmntBundle\Tests\Entity;

class UserInfoTest extends \PHPUnit_Framework_TestCase
{

  public function testUserId()
  {
    $userInfo = $this->getUserInfo();
    $this->assertNull($userInfo->getUserId());

    $userInfo->setUserId(1);
    $this->assertEquals(1,$userInfo->getUserId());
  }

  public function testName()
  {
    $userInfo = $this->getUserInfo();
    $this->assertNull($userInfo->getName());

    $userInfo->setName('UserName');
    $this->assertEquals('UserName', $userInfo->getName());
  }

  public function tesLastName()
  {
    $userInfo -> $this->getUserInfo();
    $this->assertNull($userInfo->getLastName());

    $userInfo->setLastName('LastName');
    $this->assertEquals('LastName',$userInfo->getLastName());
  }

   protected function getUserinfo()
  {
    return $this->getMockForAbstractClass('SFM\PicmntBundle\Entity\UserInfo');
  }

}