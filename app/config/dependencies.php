<?php

use Pimple\Container as PimpleContainer;

$dependencies = new PimpleContainer();
$dependencies['settings'] = $settings;

// ----------------------------------------- Redis

use Predis\Client as RedisClient;

$dependencies[RedisClient::class] = function ($c) {
    $redisSettings = $c['settings']['redis'];
    return new RedisClient([
        'host' => $redisSettings['host'],
        'port' => $redisSettings['port']
    ]);
};

// ----------------------------------------- /Redis

// ----------------------------------------- Banco de Dados

use IntecPhp\Service\DbHandler;

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

$dependencies[DbHandler::class] = function ($c) {
    $pdo = $c[PDO::class];
    return new DbHandler($pdo);
};
// ----------------------------------------- /Banco de Dados

// ----------------------------------------- Account

use IntecPhp\Model\Account;

$dependencies[Account::class] = function ($c) {
    $session = $c['settings']['session'];
    $redis = $c[RedisClient::class];
    return new Account($redis, $session['cookie_name'], $session['cookie_expires']);
};

// ----------------------------------------- /Account

// ----------------------------------------- Middlewares 500, 403, 404

use IntecPhp\Middleware\AuthenticationMiddleware;
use IntecPhp\Middleware\HttpMiddleware;
use IntecPhp\View\Layout;

$dependencies[AuthenticationMiddleware::class] = function ($c) {
    $layout = new Layout();
    $account = $c[Account::class];
    return new AuthenticationMiddleware($layout, $account);
};

$dependencies[HttpMiddleware::class] = function ($c) {
    $layout = new Layout();
    return new HttpMiddleware($layout, $c['settings']['display_errors']);
};

// ----------------------------------------- /Middlewares 500, 403, 404
