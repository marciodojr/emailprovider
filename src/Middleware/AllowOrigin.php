<?php

namespace Mdojr\EmailProvider\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Mdojr\EmailProvider\View\Layout;

class AllowOrigin implements MiddlewareInterface
{
    use Helper\AcceptJson;

    private $layout;

    public function __construct()
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {

        if($request->getMethod() !== 'OPTIONS') {
            $response = $handler->handle($request);
        } else {
            $response = $handler->getResponse();
        }

        return $response
            ->withHeader('access-control-allow-origin', '*')
            ->withHeader('access-control-allow-headers', 'x-token');
    }
}
