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

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $response = $handler->handle($request);
        if($response->getStatusCode() != 404) {
            return $response;
        }
        return $response->json(404, 'Página não encontrada');
    }
}
