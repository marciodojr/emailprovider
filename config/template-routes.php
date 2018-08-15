<?php

namespace Mdojr\EmailProvider;

return [
    [
        'pattern' => '/',
        'callback' => function($request, $response) {
            $layout = new View\Layout();
            $layout
                ->addScript('/js/login.min.js')
                ->render('home/index');

            return $response;
        }
    ],
    [
        'pattern' => '/dashboard',
        'middlewares' => [
            Middleware\Auth::class,
        ],
        'callback' => function($request, $response) {
            $layout = new View\Layout('layout-dashboard');
            $layout
                ->addScript('/js/dashboard.min.js')
                ->render('dashboard/index');

            return $response;
        }
    ]
];
