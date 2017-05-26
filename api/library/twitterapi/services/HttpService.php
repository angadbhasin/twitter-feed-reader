<?php

namespace TwitterAPI\services;

class HttpService
{
    /**
     * Instance of this class
     *
     * @var object
     * 
     */
    protected static $instance = null;
    
    /**
     * API Configuration data
     * 
     * @var array
     * 
     */
    private $conf = array();
    
    /**
     * Returns an Object of this class
     * 
     * @param array $conf  Config data
     * 
     */
    public static function getInstance($conf)
    {
        if (HttpService::$instance === null) {
            HttpService::$instance = new HttpService($conf);
        }
        return HttpService::$instance;
    }
    
    /**
     * Default class constructor
     * @param unknown $conf Configuration data
     * 
     */
    private function __construct($conf)
    {
        $this->conf = $conf;
    }
    
    /**
     * Process the request and return tweet data
     * 
     * @param string $requestMethod Http Verb
     * @param string $endPoint      Url for making the request
     * @param array  $params        Request Parameters 
     * 
     * @return JSON  tweet data
     * 
     */
    public function processRequest($requestMethod, $endPoint, $params)
    {
        $key            = $this->makeOAuthKey(); //TODO: Move oAut related login in it's own class
        $oAuthData      = $this->makeOAuthData($params);
        $oAuthSignature = $this->createSignature($key, $oAuthData, $endPoint, $requestMethod);
        $header         = $this->buildAuthHeader($oAuthData,$oAuthSignature);

        $data = $this->makeRequest($requestMethod, $endPoint, $header);
        
        return $data;
    }
    
    /**
     * Create a hearder for making an oAuth request
     * 
     * @param array $oAuthData      Data for oAuth Header
     * @param string $signature     oAuth Signature
     * 
     * @return array    Header
     * 
     */
    public function buildAuthHeader($oAuthData, $signature)
    {
        $header         = "Authorization: OAuth ";
        $headerValues   = array();
        $oAuthData      = array_merge($oAuthData, array('oauth_signature' => $signature));
        
        foreach($oAuthData as $key => $value) {
            $headerValues[] = "$key=\"".rawurlencode($value)."\"";
        }
        
        $header .= implode(",", $headerValues);

        return array($header);
    }
    
    /**
     * Generate a key for making an oAuth request
     * 
     * @return string  $key  oAuth Key
     * 
     */
    public function makeOAuthKey()
    {
        $apiSecret = $this->conf["api_secret"];
        $oAuthTokenSecret = $this->conf["oAuth_token_secret"];
        
        $key = rawurlencode($apiSecret)."&".rawurlencode($oAuthTokenSecret);
        
        return $key;
    }
    
    /**
     * Create a signature for making an oAuth requesst
     * 
     * @param string    $ckey           key for oAuth request  
     * @param array     $oAuthData      oAuth header data
     * @param string    $endPoint       destination URL
     * @param string    $requestMethod  Http verb
     * 
     * @return string   Signature for oAuth request
     */
    public function createSignature($ckey, $oAuthData, $endPoint, $requestMethod)
    {

        ksort($oAuthData);
        
        foreach($oAuthData as $key => $value)
        {
            $temp[] = rawurlencode($key) . '=' . rawurlencode($value);
        }
        
        $url    = strtok($endPoint, "?");
        $data   = $requestMethod."&".rawurlencode($url)."&".rawurlencode(implode('&',$temp));
        
        
        $signature = hash_hmac("sha1", $data, $ckey, true);
        
        return base64_encode($signature);
    }
    
    /**
     * Format data for oAuth request in required format (ref: oAuthbible)
     * 
     * @param array $params request parameters
     * 
     * @return array data formatted for oAuth request
     * 
     */
    public function makeOAuthData($params)
    {
        $data   = '';
        $now    = time();
        
        $oAuthData = array(
            'oauth_consumer_key'    => $this->conf['api_key'],
            'oauth_nonce'           => $now,
            'oauth_signature_method'=> 'HMAC-SHA1',
            'oauth_token'           => $this->conf['oAuth_access_token'],
            'oauth_timestamp'       => $now,
            'oauth_version'         => $this->conf['oAuth_version']
        );
        
        $oAuthData = array_merge($oAuthData, $params);
        
        foreach($oAuthData as $key => $value) {
            $oauthData[rawurlencode($key)] = rawurlencode($value);
        }
        
        return $oAuthData;
    }
    
    /**
     * Make the request and retrieve the data
     * 
     * @param string    $requestMethod  Http Verb
     * @param string    $url            Destination URL
     * @param array     $header         Request Header
     * 
     * @return  json    Tweets as a JSON formatted string
     * 
     */
    public function makeRequest($requestMethod, $url, $header)
    {
        // Build list of cURL options for request
        $cURLOptions = array(
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_HEADER          => false,
            CURLOPT_HTTPHEADER      => $header,
            CURLOPT_TIMEOUT         => 15,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_SSL_VERIFYHOST  => false
        );
        
        $ch = curl_init();
        curl_setopt_array($ch, $cURLOptions);
        
        //make request and save capture the response
        $response = curl_exec($ch);
        
        // close cURL handle
        curl_close($ch);
        
        return $response;
    }
}