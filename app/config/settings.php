<?php

// as chaves iguais serão sobrescritas pelo array em settings.local.php

return [
    'display_errors' => true,
    'db' => [
        'host' => 'mysql',
        'db_name' => 'phpstart',
        'db_user' => 'phpstart_admin',
        'db_pass' => 'admin',
        'charset' => 'utf8mb4'
    ],
    'redis' => [
        'host' => 'redis',
        'port' => 6379
    ],
    'session' => [
        'cookie_name' => 'app_ssid',
        'cookie_expires' => 1800 // 30 min
    ],
];
