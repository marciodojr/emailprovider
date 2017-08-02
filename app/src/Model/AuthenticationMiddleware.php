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
                SimpleRouter::redirectTo('/403');
                exit;
            }
            http_response_code(403);
        }
    }
}
