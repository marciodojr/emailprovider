<?php

namespace Mdojr\EmailProvider;

use Mdojr\EmailProvider\View\Layout;
use Mdojr\EmailProvider\Middleware\AuthenticationMiddleware;

return [
    [
        'pattern' => '/user/login',
        'callback' => Controller\LoginController::class . ':login',
    ],
    [
        'pattern' => '/user/logout',
        'callback' => Controller\LoginController::class . ':logout',
    ],
    [
        'pattern' => '/virtual-users',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\VirtualUserController::class . ':listAll',
    ],
    [
        'pattern' => '/virtual-users/add',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\VirtualUserController::class . ':create',
    ],
    [
        'pattern' => '/virtual-users/remove',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\VirtualUserController::class . ':delete',
    ],
    [
        'pattern' => '/virtual-domains',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\DomainController::class . ':listAll',
    ],
    [
        'pattern' => '/virtual-domains/add',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\DomainController::class . ':create',
    ],
    [
        'pattern' => '/virtual-domains/edit',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\DomainController::class . ':update',
    ],
    [
        'pattern' => '/virtual-domains/remove',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\DomainController::class . ':delete',
    ],
    [
        'pattern' => '/virtual-aliases',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\VirtualAliasController::class . ':listAll',
    ],
    [
        'pattern' => '/virtual-aliases/add',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\VirtualAliasController::class . ':create',
    ],
    [
        'pattern' => '/virtual-aliases/remove',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => Controller\VirtualAliasController::class . ':delete',
    ]
];
