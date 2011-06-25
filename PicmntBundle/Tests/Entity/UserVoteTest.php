<?php

namespace SFM\PicmntBundle\Tests\Entity;

use SFM\PicmntBundle\Entity\UserVote;


class UserVoteTest extends \PHPUnit_Framework_TestCase{
    
    function testIdVote() {
        
        $userVote = new UserVote();
        
        $this->assertNull($userVote->getIdVote());
        
        $userVote->setIdVote(1);
        
        $this->assertEquals('1', $userVote->getIdVote());
        
    }
    
    function testIdImage() {
        $userVote = new UserVote();
        
        $this->assertNull($userVote->getIdImage());
        
        $userVote->setIdImage(1);
        
        $this->assertEquals('1', $userVote->getIdImage());
    }
    
    
    function testUserId() {
        $userVote = new UserVote();
        
        $this->assertNull($userVote->getUserId());
        
        $userVote->setUserId(1);
        
        $this->assertEquals('1', $userVote->getUserId());
    }
}

