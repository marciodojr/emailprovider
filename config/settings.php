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
            'host' => 'localhost',
            'port' => 3306,
            'dbname' => 'servermail',
            'user' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ]
    ],
    'jwt' => [
        'app_secret' => 'very_secret',
        'token_expires' => 1800 // 30 min
    ],
    'session' => [
        'cookie_name' => 'app_ssid',
        'cookie_expires' => 1800 // 30 min
    ],
];
