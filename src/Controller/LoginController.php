<?php

namespace Mdojr\EmailProvider\Controller;

use Exception;
use Mdojr\EmailProvider\Service\Auth;
use Mdojr\EmailProvider\Service\Account;

class LoginController
{
    private $auth;
    private $account;
    const DEFAULT_COST = 15;

    public function __construct(Account $account, Auth $auth)
    {
        $this->auth = $auth;
        $this->account = $account;
    }

    public function login($request, $response)
    {
        $params = $request->getParams();

        try {
            if (empty($params['username'])) {
                throw new Exception('Usuário não informado');
            }

            if (empty($params['password'])) {
                throw new Exception('Senha não informada');
            }

            $id = $this->auth->validate($params['username'], $params['password']);
            if (!$id) {
                throw new Exception('Usuário ou senha incorreta');
            }

            $token = $this->account->login([
                'id' => $id
            ]);

            return $response->json(200, 'Autenticado com sucesso', [
                'success' => 'Autenticado com sucesso',
                'token' => $token
            ]);

        } catch (Exception $e) {
            return $response->json(400, $e->getMessage(), [
                'error' => 'Usuário ou senha incorreta'
            ]);
        }
    }

    public function logout($request, $response)
    {
        try {
            $this->account->logout();
            return $response->json(200);
        } catch(Exception $e) {
            return $response->json(400, $e->getMessage());
        }
    }
}
