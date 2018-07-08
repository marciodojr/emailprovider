<?php

namespace Mdojr\EmailProvider;

return [
    [
        'pattern' => '/',
        'callback' => function() {
            $layout = new View\Layout();
            $layout
                ->addScript('/js/login.min.js')
                ->render('home/index');
        }
    ],
    [
        'pattern' => '/dashboard',
        'middlewares' => [
            Middleware\AuthenticationMiddleware::class . ':isAuthenticated',
        ],
        'callback' => function() {
            $layout = new View\Layout('layout-dashboard');
            $layout
                ->addScript('/js/dashboard.min.js')
                ->render('dashboard/index');
        }
    ]
];
