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

$loader = include './vendor/autoload.php';

use IntecPhp\Model\Config;
use Intec\Router\SimpleRouter;
Use IntecPhp\Model\Session;

Session::start();
Config::init();

SimpleRouter::setRoutes(require 'app/config/routes.php');
SimpleRouter::match($_SERVER['REQUEST_URI']);
