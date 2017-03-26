<?php
// Everything is relative to the application root now.
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

chdir(dirname(__DIR__));
if (!file_exists('./vendor/autoload.php')) {
    echo 'Please run `composer install` first!';
}

$loader = include './vendor/autoload.php';

use Intec\Router\SimpleRouter;
SimpleRouter::setRoutes(require 'app/config/routes.php');
SimpleRouter::match($_SERVER['REQUEST_URI']);
