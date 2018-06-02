<?php

namespace IntecPhp\Middleware;

use Intec\Session\Session;
use IntecPhp\View\Layout;

class AuthenticationMiddleware
{

    private $layout;
    private $isLoggedIn;

    public function __construct(Layout $layout, bool $isLoggedIn)
    {
        $this->layout = $layout;
        $this->isLoggedIn = $isLoggedIn;
    }

    public function isAuthenticated($request)
    {
        if(!$this->isLoggedIn) {
            if(!$request->isXmlHttpRequest()) {
                $this->layout
                    ->setLayout('layout-error')
                    ->render('http-error/403');
            } else {
                $rp = new ResponseHandler(403, 'Você não tem permissão para acessar este recurso');
                $rp->printJson();
            }
        }
        exit;
    }
}
