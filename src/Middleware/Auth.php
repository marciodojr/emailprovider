<?php

namespace Mdojr\EmailProvider\Middleware;

use Mdojr\EmailProvider\Service\Account;

class Auth
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function process($request, $response, $next)
    {
        $header = $request->getHeader('Authorization');
        $token = $header ? $this->getToken($header[0]) : '';
        $data = $this->account->get($token);
        if (!$token || !$data) {
            return $this->toJson($response, 403, 'Você não possui permissão para acessar este recurso');
        }
        $req = $request->withAttribute('auth', (array)$data);
        return $next($req, $response);
    }

    private function getToken($header)
    {
        if(preg_match("/Bearer\s(\S+)/", $header, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
