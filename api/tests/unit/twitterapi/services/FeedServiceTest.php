<?php

namespace tests\services;

use TwitterAPI\services\FeedService as FeedService;

class FeedServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var Mock Object
     */
    private $httpService;
    
    /**
     *
     * @var Object
     */
    private $feedService;
    
    /**
     * 
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $methods = get_class_methods('\TwitterAPI\services\HttpService');
        
        $this->httpService = $this->getMockBuilder('\TwitterAPI\services\HttpService')->disableOriginalConstructor()->getMock();
        $this->feedService = FeedService::getInstance('www.test.com', $this->httpService);
    }
    
    /**
     *
     * @test
     * @covers \TwitterAPI\services\FeedService::getInstance
     */
    public function testGetInstance()
    {
        $this->assertInstanceOf('TwitterAPI\services\FeedService', $this->feedService);
    }
    
    /**
     * 
     * @test
     * @covers \TwitterAPI\services\FeedService::getFeedData
     */
    public function testGetFeedData()
    {
        $this->httpService
            ->expects($this->once())
            ->method('makeOAuthKey')
            ->will($this->returnValue('KEY'))
        ;
        
        $this->httpService
            ->expects($this->once())
            ->method('makeOAuthData')
            ->with($this->equalTo('KEY'))
            ->will($this->returnValue('oAuth Data'))
        ;
        
        $this->httpService
            ->expects($this->once())
            ->method('createSignature')
            ->with($this->equalTo('KEY'), $this->equalTo('oAuth Data'), $this->equalTo('www.test.com?name=test&count=2'), $this->equalTo('GET'))
            ->will($this->returnValue('signatur3'))
        ;
        
        $this->httpService
            ->expects($this->once())
            ->method('buildAuthHeader')
            ->with($this->equalTo('oAuth Data'), $this->equalTo('signatur3'))
            ->will($this->returnValue(array('HEADER')))
        ;
        
        $this->httpService
            ->expects($this->once())
            ->method('makeRequest')
            ->with($this->equalTo('GET'), $this->equalTo('www.test.com?name=test&count=2'), $this->equalTo(array('HEADER')))
            ->will($this->returnValue('Some data'))
        ;
        
        $actual = $this->feedService->getFeedData(array("name"  => "test","count" => 2), 'GET');
        
        $expected = null;
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * 
     * @test
     * @covers \TwitterAPI\services\FeedService::buildFeedUrl
     */
     public function testBuildFeedUrl()
    {
        $actual = $this->feedService->buildFeedUrl(array(
            "name"  => "test",
            "count" => 2
        ));
        
        $expected = "www.test.com?name=test&count=2";

        $this->assertEquals($expected, $actual);
    }
}