<?php

namespace Mdojr\EmailProvider\Middleware;

use Mdojr\EmailProvider\Service\Account;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Auth implements MiddlewareInterface
{
    use Helper\AcceptJson;

    private $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $token = $request->getHeader('x-token');

        if (empty($token) || !$this->account->get($token[0])) {
            $resp = $handler->getResponse();
            return $resp->json(403, 'Você não possui permissão para acessar este recurso');
        }

        return $handler->handle($request);
    }
}
