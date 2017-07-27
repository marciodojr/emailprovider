<?php

namespace IntecPhp\Model;

use Intec\Router\SimpleRouter;

class AuthenticationMiddleware
{
    public static function isAuthenticated($request)
    {
        $session = Session::getInstance();

        if(!$session->exists('id')) {
            if(!$request->isXmlHttpRequest()) {
                SimpleRouter::redirectTo(SimpleRouter::ROUTE_NOT_FOUND);
            }
        }
    }
}
