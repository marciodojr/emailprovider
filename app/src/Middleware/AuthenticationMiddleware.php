<?php

namespace IntecPhp\Middleware;


use Intec\Session\Session;
use IntecPhp\View\Layout;
use IntecPhp\Model\Account;

class AuthenticationMiddleware
{

    public static function isAuthenticated($request)
    {

        if(!Account::isLoggedIn()) {
            http_response_code(403);
            if(!$request->isXmlHttpRequest()) {
                $layout  = new Layout();
                $layout
                    ->setLayout('layout-error')
                    ->render('http-error/403');
            }
        }
    }
}
