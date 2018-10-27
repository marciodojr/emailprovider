<?php

use function DI\env;
use function DI\string;
use function DI\get;
use function DI\create;
use Doctrine\ORM\EntityManager;
use function DI\value;
use function DI\factory;
use Mdojr\EmailProvider\Service\JwtWrapper;
use Mdojr\EmailProvider\Handler\NotFound;
use Mdojr\EmailProvider\Handler\PhpError;

// as chaves iguais serão sobrescritas pelo array em settings.local.php

return [
    // Slim
    'settings.displayErrorDetails' => env('DEV_MODE'),
    'settings.addContentLengthHeader' => false,
    // Log
    'logger.name' => 'AppLog',
    'logger.path' => __DIR__ . '/../logs/app.log',
    'logger.level' => \Monolog\Logger::DEBUG,
    // Orm
    'doctrine.meta.entity_path' => [
        __DIR__ . '/../src/Entity'
    ],
    'doctrine.meta.auto_generate_proxies' => env('DEV_MODE'),
    'doctrine.meta.proxy_dir' =>  __DIR__ . '/../cache/DoctrineORM/proxies',
    'doctrine.meta.cache' => null,
    // 'doctrine.meta.cache' => get(\Doctrine\Common\Cache\ApcuCache::class),
    // Connection
    'doctrine.connection' => [
        'driver' => 'pdo_mysql',
        'host' => env('DB_HOST'),
        'port' => env('DB_PORT'),
        'dbname' => env('DB_NAME'),
        'user' => env('DB_USER'),
        'password' => env('DB_PASS'),
        'charset' => 'utf8mb4',
        'platform' => get(\Doctrine\DBAL\Platforms\MySQL57Platform::class),
    ],
    // Migrations
    'doctrine.migrations.name' => 'emailprovider_migrations',
    'doctrine.migrations.namespace' => 'Mdojr\EmailProvider\Migrations',
    'doctrine.migrations.table_name' => 'doctrine_migration_versions',
    'doctrine.migrations.column_name' => 'version',
    'doctrine.migrations.migration_directory' => 'src/Migrations',
    // Auth
    'jwt.app_secret' => env('APP_SECRET'),
    'jwt.token_expires' => 18000,
    // Doctrine entity manager
    EntityManager::class => factory(function ($c) {
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            $c->get('doctrine.meta.entity_path'),
            $c->get('doctrine.meta.auto_generate_proxies'),
            $c->get('doctrine.meta.proxy_dir'),
            $c->get('doctrine.meta.cache'),
            false
        );

        return EntityManager::create($c->get('doctrine.connection'), $config);
    }),
    'logger' => factory(function ($c) {
        $logger = new \Monolog\Logger($c->get('logger.name'));
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(
            $c->get('logger.path'),
            $c->get('logger.level')
        ));
        return $logger;
    }),
    JwtWrapper::class => create()->constructor(get('jwt.app_secret'), get('jwt.token_expires')),

    // Replacing some Slim handlers
    'notFoundHandler' => create(NotFound::class),
    'phpErrorHandler' => factory(function ($c) {
        return new PhpError((bool)$c->get('settings.displayErrorDetails'), $c->get('logger'));
    }),
    'errorHandler' => get('phpErrorHandler')
];
