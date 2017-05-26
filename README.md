A simple twitter feed reader that displays the 10 most recent tweets from the salesforce twitter feed. The application updates the tweets every minute and you can also filter the results!

languages/package-managers/frameworks used:  
  
PHP 5.6.29  
composer  
Backbone js  
Underscore js  
Jquery  
Bower  
Slim 3  
PHP unit  

Application Structure  
  
|-- api (Server side code for the API that retrieves the tweets )  
|-- app (Client side code for main application )  
|-- assets (Public assets CSS, images, etc)


To install the application, you will need composer. Simply run composer install from within the api directory to install application dependencies.  
All front end dependencies are included for your convenience but you could also install them using Bower. PHP unit tests are included in the api/tests folder.  
Unit tests can be executed by using the following command  
  
".\vendor\bin\phpunit api/tests/unit"  
  
If you have a global install of PHPUnit, you can just execute the tests using the "phpunit" command from the tests/unit directory.  

I would like to thank you for presenting me with this challenge. I thoroughly enjoyed implementing this application.  

