<?php

namespace IntecPhp\Middleware;


use Intec\Session\Session;
use IntecPhp\View\Layout;
use IntecPhp\Model\Config;

class HttpMiddleware
{

    public static function pageNotFound($request)
    {
        http_response_code(404);
        if($request->isXmlHttpRequest()) {
            echo json_encode([
                'error' => [
                    'code' => 404,
                    'message' => 'Página não encontrada'
                ]
            ]);
        } else {
            $layout  = new Layout();
            $layout
                ->setLayout('layout-error')
                ->render('http-error/404');
        }
    }

    public static function fatalError($request, $err)
    {

        if(!Config::isProduction()){
            if($request->isXmlHttpRequest()) {
                die($err->getCode() .': '. $err->getMessage());
            } else {
                $layout  = new Layout();
                $layout
                    ->setLayout('layout-error')
                    ->render('http-error/500');
            }
        } else {
            error_log($err->getCode() .': '. $err->getMessage());
            if(!$request->isXmlHttpRequest()) {
                $layout  = new Layout();
                $layout
                    ->setLayout('layout-error')
                    ->render('http-error/500');
            }
        }

    }
}
