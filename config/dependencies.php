<?php


// Model

use Mdojr\EmailProvider\Model\Account;

// Controller

use Mdojr\EmailProvider\Controller\DashboardController;
use Mdojr\EmailProvider\Controller\DomainController;
use Mdojr\EmailProvider\Controller\VirtualUserController;
use Mdojr\EmailProvider\Controller\VirtualAliasController;
use Mdojr\EmailProvider\Controller\LoginController;

// Middleware

use Mdojr\EmailProvider\Middleware\AuthenticationMiddleware;
use Mdojr\EmailProvider\Middleware\HttpMiddleware;

// Service

use Mdojr\EmailProvider\Service\RedisSession;
use Mdojr\EmailProvider\Service\Auth;

// Service\Database

use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Mdojr\EmailProvider\Service\Database\Admin;

// View

use Mdojr\EmailProvider\View\Layout;

// Base

$dependencies[EntityManager::class] = function ($c) {
    $doctrine = $c['settings']['doctrine'];
    $config = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $doctrine['meta']['entity_path'],
        $doctrine['meta']['auto_generate_proxies'],
        $doctrine['meta']['proxy_dir'],
        $doctrine['meta']['cache'],
        false
    );
    return Doctrine\ORM\EntityManager::create($doctrine['connection'], $config);
};

$dependencies[Redis::class] = function ($c) {
    $redisSettings = $c['settings']['redis'];
    $redis = new Redis();
    $redis->connect($redisSettings['host'], $redisSettings['port']);
    return $redis;
};

// Model

$dependencies[Account::class] = function ($c) {
    $redisSession = $c[RedisSession::class];
    return new Account($redisSession);
};

// Controller
$dependencies[DomainController::class] = function ($c) {
    $virtualDomain = $c[VirtualDomain::class];
    return new DomainController($virtualDomain);
};
$dependencies[VirtualUserController::class] = function ($c) {
    $virtualUser = $c[VirtualUser::class];
    return new VirtualUserController($virtualUser);
};
$dependencies[VirtualAliasController::class] = function ($c) {
    $virtualAlias = $c[VirtualAlias::class];
    return new VirtualAliasController($virtualAlias);
};
$dependencies[LoginController::class] = function ($c) {
    $account = $c[Account::class];
    $auth = $c[Auth::class];
    return new LoginController($account, $auth);
};

// Service

$dependencies[RedisSession::class] = function ($c) {
    $redis = $c[Redis::class];
    $session = $c['settings']['session'];
    return new RedisSession($redis, $session['cookie_name'], $session['cookie_expires']);
};
$dependencies[Auth::class] = function ($c) {
    $admin = $c[Admin::class];
    return new Auth($admin);
};

// Service/Database

$dependencies[VirtualUser::class] = function ($c) {
    $em = $c[EntityManager::class];
    return new VirtualUser($em);
};
$dependencies[VirtualDomain::class] = function ($c) {
    $em = $c[EntityManager::class];
    return new VirtualDomain($em);
};
$dependencies[VirtualAlias::class] = function ($c) {
    $em = $c[EntityManager::class];
    return new VirtualAlias($em);
};
$dependencies[Admin::class] = function ($c) {
    $em = $c[EntityManager::class];
    return new Admin($em);
};

// Middleware

$dependencies[AuthenticationMiddleware::class] = function ($c) {
    $layout = new Layout();
    $account = $c[Account::class];
    return new AuthenticationMiddleware($layout, $account);
};

$dependencies[HttpMiddleware::class] = function ($c) {
    $layout = new Layout();
    return new HttpMiddleware($layout, $c['settings']['display_errors']);
};
