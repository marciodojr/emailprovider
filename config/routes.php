<?php

namespace Mdojr\EmailProvider;

use Mdojr\EmailProvider\Middleware\Auth;

return [
    [
        'method' => 'post',
        'pattern' => '/user/login',
        'callback' => Controller\LoginController::class . ':login',
    ],
    [
        'method' => 'get',
        'pattern' => '/virtual-users',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualUserController::class . ':listAll',
    ],
    [
        'method' => 'post',
        'pattern' => '/virtual-users',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualUserController::class . ':create',
    ],
    [
        'method' => 'delete',
        'pattern' => '/virtual-users',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualUserController::class . ':delete',
    ],
    [
        'method' => 'get',
        'pattern' => '/virtual-domains',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\DomainController::class . ':listAll',
    ],
    [
        'method' => 'post',
        'pattern' => '/virtual-domains',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\DomainController::class . ':create',
    ],
    [
        'method' => 'patch',
        'pattern' => '/virtual-domains/([0-9]+)',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\DomainController::class . ':update',
    ],
    [
        'method' => 'delete',
        'pattern' => '/virtual-domains',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\DomainController::class . ':delete',
    ],
    [
        'method' => 'get',
        'pattern' => '/virtual-aliases',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualAliasController::class . ':listAll',
    ],
    [
        'method' => 'post',
        'pattern' => '/virtual-aliases',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualAliasController::class . ':create',
    ],
    [
        'method' => 'delete',
        'pattern' => '/virtual-aliases',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualAliasController::class . ':delete',
    ]
];
