<?php

namespace Mdojr\EmailProvider\Middleware;

use Mdojr\EmailProvider\View\Layout;
use Mdojr\EmailProvider\Service\Account;

class AuthenticationMiddleware
{
    private $layout;
    private $account;

    public function __construct(Layout $layout, Account $account)
    {
        $this->layout = $layout;
        $this->account = $account;
    }

    public function isAuthenticated($request, $response)
    {
        if (!$this->account->isLoggedIn()) {
            if ($this->acceptJson($request->getHeaderLine('accept'))) {
                header('Content-Type: application/json');
                http_response_code(403);
                echo json_encode([
                    'code' => 403,
                    'message' => 'Você não tem permissão para acessar esse recurso'
                ]);
            } else {
                $this->layout
                    ->setLayout('layout-error')
                    ->render('http-error/403');
            }
        }

        return $response;
    }

    private function acceptJson($acceptHeaderLine)
    {
        return false !== strpos($acceptHeaderLine, 'application/json');
    }
}
