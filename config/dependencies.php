<?php

// Controller

use Mdojr\EmailProvider\Controller\DashboardController;
use Mdojr\EmailProvider\Controller\DomainController;
use Mdojr\EmailProvider\Controller\VirtualUserController;
use Mdojr\EmailProvider\Controller\VirtualAliasController;
use Mdojr\EmailProvider\Controller\LoginController;

// Middleware

use Mdojr\EmailProvider\Middleware\Auth as AuthMiddleware;
use Mdojr\EmailProvider\Middleware\PageNotFound;
use Mdojr\EmailProvider\Middleware\InternalServerError;

// Service

use Mdojr\EmailProvider\Service\Auth;
use Mdojr\EmailProvider\Service\JwtWrapper;
use Mdojr\EmailProvider\Service\Account;

// Service\Database

use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Mdojr\EmailProvider\Service\Database\Admin;

$container = $app->getContainer();

// Base

$container[EntityManager::class] = function ($c) {
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

// Controller
$container[DomainController::class] = function ($c) {
    $virtualDomain = $c[VirtualDomain::class];
    return new DomainController($virtualDomain);
};
$container[VirtualUserController::class] = function ($c) {
    $virtualUser = $c[VirtualUser::class];
    return new VirtualUserController($virtualUser);
};
$container[VirtualAliasController::class] = function ($c) {
    $virtualAlias = $c[VirtualAlias::class];
    return new VirtualAliasController($virtualAlias);
};
$container[LoginController::class] = function ($c) {
    $account = $c[Account::class];
    $auth = $c[Auth::class];
    return new LoginController($account, $auth);
};

// Service

$container[Auth::class] = function ($c) {
    $admin = $c[Admin::class];
    return new Auth($admin);
};

$container[JwtWrapper::class] = function ($c) {
    $jwtSettings = $c['settings']['jwt'];
    return new JwtWrapper($jwtSettings['app_secret'], $jwtSettings['token_expires']);
};

$container[Account::class] = function ($c) {
    $jwt = $c[JwtWrapper::class];
    return new Account($jwt);
};

// Service/Database

$container[VirtualUser::class] = function ($c) {
    $em = $c[EntityManager::class];
    return new VirtualUser($em);
};
$container[VirtualDomain::class] = function ($c) {
    $em = $c[EntityManager::class];
    return new VirtualDomain($em);
};
$container[VirtualAlias::class] = function ($c) {
    $em = $c[EntityManager::class];
    return new VirtualAlias($em);
};
$container[Admin::class] = function ($c) {
    $em = $c[EntityManager::class];
    return new Admin($em);
};

// Middleware
$container[AuthMiddleware::class] = function ($c) {
    $account = $c[Account::class];
    return new AuthMiddleware($account);
};

$container[InternalServerError::class] = function ($c) {
    $showErrors = $c['settings']['display_errors'];
    return new InternalServerError($showErrors);
};

// Handlers
$container['notFoundHandler'] = function ($c) {
    return new \Mdojr\EmailProvider\Handler\NotFound;
};
