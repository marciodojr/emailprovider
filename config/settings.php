<?php

// as chaves iguais serão sobrescritas pelo array em settings.local.php

return [
    'display_errors' => true,
    'doctrine' => [
        'meta' => [
            'entity_path' => [
                __DIR__ . '/../src/Entity'
            ],
            'auto_generate_proxies' => true,
            'proxy_dir' =>  __DIR__ . '/../cache/DoctrineORM/proxies',
            'cache' => null,
        ],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => getenv('DB_HOST'),
            'port' => 3306,
            'dbname' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'password' =>  getenv('DB_PASS'),
            'charset' => 'utf8mb4',
        ]
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
