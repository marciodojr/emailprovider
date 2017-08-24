<?php

namespace IntecPhp\Middleware;


use Intec\Session\Session;
use IntecPhp\View\Layout;


class AuthenticationMiddleware
{

    public static function isAuthenticated($request)
    {
        $session = Session::getInstance();

        if(!$session->exists('id')) {
            http_response_code(403);
            if(!$request->isXmlHttpRequest()) {
                $layout  = new Layout();
                $layout
                    ->setLayout('layout-error')
                    ->render('http-error/403');
            }
            exit;
        }
    }
}
