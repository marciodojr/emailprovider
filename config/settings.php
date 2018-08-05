<?php

// as chaves iguais serão sobrescritas pelo array em settings.local.php

return [
    'display_errors' => getenv('DEV_MODE'),
    'doctrine' => [
        'meta' => [
            'entity_path' => [
                __DIR__ . '/../src/Entity'
            ],
            'auto_generate_proxies' => getenv('DEV_MODE'),
            'proxy_dir' =>  __DIR__ . '/../cache/DoctrineORM/proxies',
            'cache' => getenv('DEV_MODE') ? null : new \Doctrine\Common\Cache\ApcuCache(),
        ],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'dbname' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'password' =>  getenv('DB_PASS'),
            'charset' => 'utf8mb4',
            'platform' => new \Doctrine\DBAL\Platforms\MySQL57Platform()
        ],
        'migrations' => [
            'name' => 'emailprovider_migrations',
            'namespace' => 'Mdojr\EmailProvider\Migrations',
            'table_name' => 'doctrine_migration_versions',
            'column_name' => 'version',
            'migration_directory' => 'src/Migrations'
        ],
    ],
    'jwt' => [
        'app_secret' => getenv('APP_SECRET'),
        'token_expires' => 1800 // 30 min
    ],
    'session' => [
        'cookie_name' => getenv('APP_COOKIE_NAME'),
        'cookie_expires' => 1800 // 30 min
    ],
];
