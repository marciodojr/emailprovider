<?php

//Everything is relative to the application root now.
chdir(dirname(__DIR__));
if (!file_exists('./vendor/autoload.php')) {
    echo 'Please run `composer install` first!';
}

$localConfigFile = './app/config/config.local.php';

if (file_exists($localConfigFile)) {
    require_once $localConfigFile;
}

include './vendor/autoload.php';

use IntecPhp\Model\Config;
use Intec\Router\SimpleRouter;
use Intec\Tracker\Middleware\TrackerMiddleware;
use IntecPhp\Middleware\HttpMiddleware;

Config::init();

SimpleRouter::setRoutes(require 'app/config/routes.php');

SimpleRouter::setNotFoundFallback(function($request){
    HttpMiddleware::pageNotFound($request);
});

SimpleRouter::setErrorFallback(function($request, $err){
    HttpMiddleware::fatalError($request, $err);
});

SimpleRouter::match($_SERVER['REQUEST_URI']);
