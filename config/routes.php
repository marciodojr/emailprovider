<?php

namespace Mdojr\EmailProvider;

use Mdojr\EmailProvider\Middleware\Auth;

return [
    [
        'pattern' => '/user/login',
        'callback' => Controller\LoginController::class . ':login',
    ],
    [
        'pattern' => '/virtual-users',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualUserController::class . ':listAll',
    ],
    [
        'pattern' => '/virtual-users/add',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualUserController::class . ':create',
    ],
    [
        'pattern' => '/virtual-users/remove',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualUserController::class . ':delete',
    ],
    [
        'pattern' => '/virtual-domains',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\DomainController::class . ':listAll',
    ],
    [
        'pattern' => '/virtual-domains/add',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\DomainController::class . ':create',
    ],
    [
        'pattern' => '/virtual-domains/edit',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\DomainController::class . ':update',
    ],
    [
        'pattern' => '/virtual-domains/remove',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\DomainController::class . ':delete',
    ],
    [
        'pattern' => '/virtual-aliases',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualAliasController::class . ':listAll',
    ],
    [
        'pattern' => '/virtual-aliases/add',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualAliasController::class . ':create',
    ],
    [
        'pattern' => '/virtual-aliases/remove',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => Controller\VirtualAliasController::class . ':delete',
    ]
];
