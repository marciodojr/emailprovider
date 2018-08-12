<?php

namespace Mdojr\EmailProvider\Middleware;

use Mdojr\EmailProvider\View\Layout;
use Mdojr\EmailProvider\Model\Config;

class HttpMiddleware
{
    private $layout;
    private $displayErrors;

    public function __construct(Layout $layout, bool $displayErrors)
    {
        $this->layout = $layout;
        $this->displayErrors = $displayErrors;
    }

    public function pageNotFound($request, $response)
    {
        if ($this->acceptJson($request->getHeaderLine('accept'))) {
            return $response->json(404, 'Página não encontrada.');
        } else {
            $this->layout
                ->setLayout('layout-error')
                ->render('http-error/404');
        }
    }

    public function fatalError($request, $response, $next, $err)
    {
        if ($this->acceptJson($request->getHeaderLine('accept'))) {

            $err = $this->displayErrors ? [
                'message' => $err->getMessage(),
                'code' => $err->getCode(),
                'file' => $err->getFile(),
                'line' => $err->getLine()
            ] : [];
            return $response->json(500, 'Erro inesperado', $err);
        } else {
            $this->layout
                    ->setLayout('layout-error')
                    ->render('http-error/500', ['e' => $err, 'displayErrors' => $this->displayErrors]);
        }
    }

    private function acceptJson($acceptHeaderLine)
    {
        return false !== strpos($acceptHeaderLine, 'application/json');
    }
}
