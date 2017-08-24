<?php

namespace IntecPhp\Middleware;


use Intec\Session\Session;
use IntecPhp\View\Layout;
use IntecPhp\Model\Config;

class HttpMiddleware
{

    public static function pageNotFound($request)
    {
        $layout  = new Layout();
        $layout
            ->setLayout('layout-error')
            ->render('http-error/404');
    }

    public static function fatalError($request, $err)
    {

        if(Config::isProduction()){
            error_log($err);
        }

        $layout  = new Layout();
        $layout
            ->setLayout('layout-error')
            ->render('http-error/500');
    }
}
