<?php

$container = new \Slim\Container($settings);

/********************************************************************
 *                            services                              *
 ********************************************************************/
$container["HttpService"] = function($c) {

    $apiConf = $c["settings"]["API CREDENTIALS"];

    return TwitterAPI\services\HttpService::getInstance($apiConf);
};

$container["FeedService"] = function($c) {
    
    $apiURL     = $c["settings"]["API URL"];
    $httpService= $c['HttpService'];
    
    return TwitterAPI\services\FeedService::getInstance($apiURL, $httpService);
};


/********************************************************************
 *                            controllers                           *
 ********************************************************************/

$container["IndexController"] = function($c) {
    $feedService = $c["FeedService"];
    
    return new app\controllers\IndexController($feedService);
};