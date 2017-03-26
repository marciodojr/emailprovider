<?php

return [
    [
        'pattern' => '(/|/index|/home)',
        'callback' => function() {
            echo 'Home';
        },
    ],
	[
        'pattern' => '/hello',
        'callback' => function() {
            echo 'Hello!';
        },
    ],
];
