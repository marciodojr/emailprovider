<?php

use IntecPhp\Model\Account;

use IntecPhp\Middleware\AuthenticationMiddleware;
use IntecPhp\Middleware\HttpMiddleware;

use IntecPhp\Service\RedisSession;
use IntecPhp\Service\DbHandler;

use IntecPhp\View\Layout;


$dependencies[Redis::class] = function ($c) {
    $redisSettings = $c['settings']['redis'];
    $redis = new Redis();
    $redis->connect($redisSettings['host'], $redisSettings['port']);
    return $redis;
};

$dependencies[PDO::class] = function ($c) {
    $db = $c['settings']['db'];

    return new PDO(
        'mysql:host='.$db['host'].';dbname='.$db['db_name'].';charset=' . $db['charset'],
        $db['db_user'],
        $db['db_pass'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
};

// ----------------------------------------- Model

$dependencies[Account::class] = function ($c) {
    $redisSession = $c[RedisSession::class];
    return new Account($redisSession);
};

// ----------------------------------------- /Model

// ----------------------------------------- Service

$dependencies[DbHandler::class] = function ($c) {
    $pdo = $c[PDO::class];
    return new DbHandler($pdo);
};

$dependencies[RedisSession::class] = function ($c) {
    $redis = $c[Redis::class];
    $session = $c['settings']['session'];
    return new RedisSession($redis, $session['cookie_name'], $session['cookie_expires']);
};

// ----------------------------------------- /Service

// ----------------------------------------- Middleware

$dependencies[AuthenticationMiddleware::class] = function ($c) {
    $layout = new Layout();
    $account = $c[Account::class];
    return new AuthenticationMiddleware($layout, $account);
};

$dependencies[HttpMiddleware::class] = function ($c) {
    $layout = new Layout();
    return new HttpMiddleware($layout, $c['settings']['display_errors']);
};


// ----------------------------------------- /Middleware
