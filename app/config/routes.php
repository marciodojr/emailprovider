<?php

namespace IntecPhp;

use IntecPhp\View\Layout;
use IntecPhp\Model\AuthenticationMiddleware;

return [
    [
        'pattern' => '(/|/index|/home)',
        'callback' => function() {
            $layout = new Layout();
            $layout

                ->render('home/index');
        },
    ],
    [
        'pattern' => '/components',
        'callback' => function() {
            $layout = new Layout();
            $layout->render('home/components');
        },
    ],
    [
        'pattern' => '/bootstrap',
        'callback' => function() {
            $layout = new Layout();
            $layout->render('home/bootstrap');
        },
    ],
    [
        'pattern' => '/validator',
        'callback' => function() {
            $layout = new Layout();
            $layout->render('home/validator');
        },
    ],
    [
        'pattern' => '/icons',
        'callback' => function() {
            $layout = new Layout();
            $layout
                ->addStylesheet('/css/icons.min.css')
                ->render('home/icons');
        }
    ],
    [
        'pattern' => '/ajax-form',
        'callback' => function() {
            $layout = new Layout();
            $layout
                ->render('home/ajax-form');
        }
    ],
    [
        'pattern' => '/ajax-form-submit',
        'callback' => function() {
            http_response_code(404);
            echo json_encode([
                'errorMessage' => 'O recurso solicitado não está mais disponível',
            ]);
        }
    ],
	[
        'pattern' => '/hello',
        'callback' => function() {
            $layout = new Layout();
            $layout
                ->addStylesheet('/css/hello.min.css')
                ->addScript('/js/hello.min.js')
                ->render('hello/index', Controller\HelloController::index());
        },
    ],
    [
        'pattern' => '/user-area',
        'middlewares' => [
            function($request) {
                AuthenticationMiddleware::isAuthenticated($request);
            },
        ],
        'callback' => function() {
            die('Acesso liberado');
        },
    ],
    [
        'pattern' => '/404',
        'callback' => function() {
            $layout = new Layout();
            $layout->render('home/404');
        }
    ],
    [
        'pattern' => '/403',
        'callback' => function() {
            $layout = new Layout();
            $layout->render('home/403');
        }
    ],
    [
        'pattern' => '/facebook/pages',
        'callback' => function() {
            $layout = new Layout();
            $layout
                ->addScript('/js/facebookPages.min.js')
                ->render('facebook/pages', Controller\FacebookController::page());
        }
    ],
    [
        'pattern' => '/facebook/requestPageAccessToken',
        'callback' => function() {
            Controller\FacebookController::requestPageAccessToken();
        }
    ],
];
