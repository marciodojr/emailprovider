<?php

// as chaves iguais serão sobrescritas pelo array em settings.local.php

return [
    'display_errors' => true,
    'redis' => [
        'host' => 'localhost',
        'port' => 6379
    ],
    'session' => [
        'cookie_name' => 'app_ssid',
        'cookie_expires' => 1800 // 30 min
    ],
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
    ]
];
