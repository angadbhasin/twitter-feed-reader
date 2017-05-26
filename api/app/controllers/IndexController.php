<?php

namespace app\controllers;

use TwitterAPI\services\FeedService as FeedService;

class IndexController
{
    /**
     * Instance of feed service
     * 
     * @var unknown
     */
    private $feedService;
    
    /**
     * Default class constructor
     * 
     * @param FeedService $feedService Instance of feed service class
     */
    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }
    
    /**
     * Returns a set number of tweets for a given user
     * 
     * @route /tweets
     * @param unknown $request
     * @param unknown $response
     * @param unknown $params
     * 
     * @return JSON response
     * 
     */
    public function viewFeedAction($request, $response, $params)
    {
        $requestMethod  = "GET";
        $screenName     = $params['screen_name'];
        $postCount      = $params['count'];
        $params         = array("screen_name" => $screenName, "count" => $postCount);
        
        $feed = $this->feedService->getFeedData($params, $requestMethod);

        return $response->withJson($feed);
    }
}