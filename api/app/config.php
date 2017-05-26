<?php

// Settings for the app to work
// Add you API keys here
$settings = array (
    "settings" => array (
        "API URL"           => "https://api.twitter.com/1.1/statuses/user_timeline.json",
        "API CREDENTIALS"   => array (
            "oAuth_access_token"=> "YOUR_ACCESS_TOKEN_HERE",
            "oAuth_token_secret"=> "YOUR_OAUTH_SECRET_HERE",
            "api_key"           => "YOUR_CONSUMER_API_KEY_HERE",
            "api_secret"        => "YOUR_CONSUMER_API_SECRET_HERE",
            "oAuth_version"     => "1.0"
        )
    )
);

return $settings;