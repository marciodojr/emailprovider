<?php

use Mdojr\EmailProvider\App;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManager;

//Everything is relative to the application root now.
chdir(dirname(__DIR__));

require './vendor/autoload.php';

$settings = require 'config/settings.php';
if(file_exists('config/settings.local.php')) {
    $settings = array_replace_recursive($settings, require './config/settings.local.php');
}

$app = new App($settings);
$container = $app->getContainer();

$em = $container->get(EntityManager::class);

// Migrations Configuration
$connection = $em->getConnection();
$configuration = new Configuration($connection);
$configuration->setName($container->get('doctrine.migrations.name'));
$configuration->setMigrationsNamespace($container->get('doctrine.migrations.namespace'));
$configuration->setMigrationsTableName($container->get('doctrine.migrations.table_name'));
$configuration->setMigrationsColumnName($container->get('doctrine.migrations.column_name'));
$configuration->setMigrationsDirectory($container->get('doctrine.migrations.migration_directory'));

return new HelperSet([
    'em' => new EntityManagerHelper($em),
    'db' => new ConnectionHelper($connection),
    new ConfigurationHelper($connection, $configuration)
]);
