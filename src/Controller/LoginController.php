<?php

namespace Mdojr\EmailProvider\Controller;

use Exception;
use Mdojr\EmailProvider\Service\Auth;
use Mdojr\EmailProvider\Service\Account;

class LoginController
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $auth;
    private $account;

    public function __construct(Account $account, Auth $auth)
    {
        $this->auth = $auth;
        $this->account = $account;
    }

    public function login($request, $response)
    {
        $params = $request->getParams();

        try {
            if (empty($params['username']) || empty($params['password'])) {
                throw new Exception('Informe o nome de usuário e a senha');
            }

            $id = $this->auth->validate($params['username'], $params['password']);
            if (!$id) {
                throw new Exception('Usuário ou senha incorreta');
            }

            $token = $this->account->login([
                'id' => $id
            ]);

            return $this->toJson($response, 200, 'Autenticado com sucesso', [
                'token' => $token
            ]);

        } catch (Exception $e) {
            return $this->toJson($response, 400, $e->getMessage());
        }
    }
}
