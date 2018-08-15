<?php

namespace Mdojr\EmailProvider\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Mdojr\EmailProvider\View\Layout;

class PageNotFound implements MiddlewareInterface
{
    use Helper\AcceptJson;

    private $layout;

    public function __construct(Layout $layout)
    {
        $this->layout = $layout;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $response = $handler->handle($request);
        if($response->getStatusCode() !== 404) {
            return $response;
        }

        if($this->acceptJson($request->getHeaderLine('accept'))) {
            return $response->json(404, 'Página não encontrada');
        }

        $this->layout->render('http-error/404');
        return $response;
    }
}
