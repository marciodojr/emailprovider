<?php

namespace IntecPhp;

use IntecPhp\View\Layout;

return [
    [
        'pattern' => '(/|/index|/home)',
        'callback' => function() {
            echo 'index';
        },
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
];
