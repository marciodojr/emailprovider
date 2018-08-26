<?php

require __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

$app = new \Slim\App([
    'settings' => require __DIR__ . '/../config/settings.php'
]);

require __DIR__ . '/../config/dependencies.php';
require __DIR__ . '/../config/routes.php';

// Setup database
$container = $app->getContainer();
$em = $container->get(EntityManager::class);
$schema = $em->getMetadataFactory()->getAllMetadata();
$tool = new SchemaTool($em);
$tool->dropSchema($schema);
$tool->createSchema($schema);

// setup admin user
$conn = $em->getConnection();
$conn->executeQuery("INSERT INTO admin(id, username, password, is_active) values(?, ?, ?, ?)", [
    1,
    'admin',
    '$2y$10$KWCCBmkpsWeKZ7lyvSbSDenlNBZ02OL7SrggykoudhrQC5GjTOrBG',
    1
]);
