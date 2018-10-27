<?php

namespace Mdojr\EmailProvider\Action;

use Exception;
use Mdojr\EmailProvider\Service\Auth;
use Mdojr\EmailProvider\Service\JwtWrapper;

class Login
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $auth;
    private $jwt;

    public function __construct(JwtWrapper $jwt, Auth $auth)
    {
        $this->auth = $auth;
        $this->jwt = $jwt;
    }

    public function __invoke($request, $response)
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

            $token = $this->jwt->encode([
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
