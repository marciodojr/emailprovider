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

// Model

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

$dependencies[Auth::class] = function ($c) {
    $admin = $c[Admin::class];
    return new Auth($admin);
};

$dependencies[JwtWrapper::class] = function ($c) {
    $jwtSettings = $c['settings']['jwt'];
    return new JwtWrapper($jwtSettings['app_secret'], $jwtSettings['token_expires']);
};

$dependencies[Account::class] = function ($c) {
    $jwt = $c[JwtWrapper::class];
    return new Account($jwt);
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

$dependencies[AuthMiddleware::class] = function ($c) {
    $layout = new Layout('layout-error');
    $account = $c[Account::class];
    return new AuthMiddleware($layout, $account);
};

$dependencies[InternalServerError::class] = function ($c) {
    $layout = new Layout('layout-error');
    $showErrors = $c['settings']['display_errors'];
    return new InternalServerError($layout, $showErrors);
};

$dependencies[PageNotFound::class] = function ($c) {
    $layout = new Layout('layout-error');
    return new PageNotFound($layout);
};
