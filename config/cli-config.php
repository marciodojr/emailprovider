<?php

require 'vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;


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

return ConsoleRunner::createHelperSet($em);
