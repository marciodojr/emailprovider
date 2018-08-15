<?php

require 'vendor/autoload.php';

use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;

$settings = require 'config/settings.php';

if(file_exists('config/settings.local.php')) {
    $settings = array_replace_recursive($settings, require 'config/settings.local.php');
}

$doctrineSettings = $settings['doctrine'];

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $doctrineSettings['meta']['entity_path'],
    $doctrineSettings['meta']['auto_generate_proxies'],
    $doctrineSettings['meta']['proxy_dir'],
    $doctrineSettings['meta']['cache'],
    false
);

$em = \Doctrine\ORM\EntityManager::create($doctrineSettings['connection'], $config);

// Migrations Configuration
$connection = $em->getConnection();

$migrations = $doctrineSettings['migrations'];
$configuration = new Configuration($connection);
$configuration->setName($migrations['name']);
$configuration->setMigrationsNamespace($migrations['namespace']);
$configuration->setMigrationsTableName($migrations['table_name']);
$configuration->setMigrationsColumnName($migrations['column_name']);
$configuration->setMigrationsDirectory($migrations['migration_directory']);

return new HelperSet([
    'em' => new EntityManagerHelper($em),
    'db' => new ConnectionHelper($connection),
    new ConfigurationHelper($connection, $configuration)
]);
