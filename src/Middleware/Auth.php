<?php

namespace Mdojr\EmailProvider\Middleware;

use Mdojr\EmailProvider\View\Layout;
use Mdojr\EmailProvider\Service\Account;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Auth implements MiddlewareInterface
{
    use Helper\AcceptJson;

    private $layout;
    private $account;

    public function __construct(Layout $layout, Account $account)
    {
        $this->layout = $layout;
        $this->account = $account;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $token = $request->getHeader('x-token');

        if (empty($token) || !$this->account->get($token[0])) {
            $resp = $handler->getResponse();
            if ($this->acceptJson($request->getHeaderLine('accept'))) {
                return $resp->json(403, 'Você não possui permissão para acessar este recurso');
            }

            $this->layout->render('http-error/403');
            return $resp;
        }

        return $handler->handle($request);
    }
}
