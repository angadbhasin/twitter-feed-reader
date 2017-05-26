<?php

require_once __DIR__."/app/config.php";
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/app/container.php";

$app = new \Slim\App($container);

require_once __DIR__."/app/routes.php";

$app->run();