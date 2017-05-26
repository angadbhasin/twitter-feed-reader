<?php

namespace TwitterAPI\services;

use TwitterAPI\services\HttpService as HttpService;

class FeedService
{
    /**
     * Instance of this class
     *
     * @var object
     */
    protected static $instance = null;
    
    /**
     * URL API STRING
     *
     * @var string
     */
    private $apiURL = null;
    
    /**
     * Instance of HttpService
     * 
     * @var object
     */
    
    private $httpService;
    
    /**
     * Returns an Object of this class
     * 
     */
    public static function getInstance($apiURL, HttpService $httpService)
    {
        if (FeedService::$instance === null) {
            FeedService::$instance = new FeedService($apiURL, $httpService);
        }
        return FeedService::$instance;
    }
    
    /**
     * Default constructor 
     * 
     * @param string $apiURL    url
     * @param HttpService $httpService
     * 
     */
    private function __construct($apiURL, HttpService $httpService)
    {
        $this->apiURL       = $apiURL;
        $this->httpService  = $httpService;
    }
    
    /**
     * Retrieve set number of tweets for a given user
     * 
     * @param array     $params         Request parameters
     * @param string    $requestMethod  Http verb
     * 
     * @return JSON     retrieved tweets
     * 
     */
    public function getFeedData($params, $requestMethod)
    {        
        $endPoint = $this->buildFeedURL($params);
        
        $feedData = $this->httpService->processRequest($requestMethod, $endPoint, $params);

        return $feedData;
    }
    
    /**
     * Build an encoded URL string with request parameters
     * 
     * @param   array   $params Request parameters
     * 
     * @return  string  Correctly encoded URL string
     * 
     */
    public function buildFeedURL($params)
    {
        $queryString= http_build_query($params);
        
        return $this->apiURL."?".$queryString;
    }
}