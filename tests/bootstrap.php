<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new \Mdojr\EmailProvider\App(require __DIR__ . '/../config/settings.php');

require __DIR__ . '/../config/routes.php';
