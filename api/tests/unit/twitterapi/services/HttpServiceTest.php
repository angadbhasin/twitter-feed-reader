<?php

namespace tests\services;

use TwitterAPI\services\HttpService as HttpService;

class HttpServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * 
     * @var Mock Object
     */
    private $httpService;
    
    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     * 
     */
    public function setUp()
    {
        $config = array (
            "oAuth_access_token"=> "access_token",
            "oAuth_token_secret"=> "access_token_secret",
            "api_key"           => "api_key",
            "api_secret"        => "api_secret",
            "oAuth_version"     => "1.0"
        );
        $this->httpService = HttpService::getInstance($config);
    }
    
    /**
     * @test
     * @covers \TwitterAPI\services\HttpService::getInstance
     * 
     */
    public function testGetInstance()
    {
        $this->assertInstanceOf('TwitterAPI\services\HttpService', $this->httpService);
    }
    
    /**
     * @test
     * @covers \TwitterAPI\services\HttpService::makeOAuthKey
     * 
     */
    public function testMakeOAuthKey()
    {
        $expected = "api_secret&access_token_secret";
        
        $actual = $this->httpService->makeOAuthKey();
        
        $this->assertEquals($expected, $actual);
    }
    
    /**
     * @test
     * @covers \TwitterAPI\services\HttpService::buildAuthHeader
     *
     */
    public function testBuildAuthHeader()
    {
        $oAuthData = array("data key1" => "data Value 1", "data Key2" => "data Value 2");
        
        $expected = array('Authorization: OAuth data key1="data%20Value%201",data Key2="data%20Value%202",oauth_signature="Signature"');
        
        $actual = $this->httpService->buildAuthHeader($oAuthData, "Signature");
        
        $this->assertEquals($expected, $actual);
    }
}