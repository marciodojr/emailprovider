<?php

require __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

$app = new \Slim\App([
    'settings' => require __DIR__ . '/../config/settings.php'
]);

require __DIR__ . '/../config/dependencies.php';
require __DIR__ . '/../config/routes.php';
