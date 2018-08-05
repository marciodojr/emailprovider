<?php

namespace Mdojr\EmailProvider\Service;

use Mdojr\EmailProvider\Service\JwtWrapper;
use Mdojr\EmailProvider\Service\Cookie;
use Exception;

class Account
{
    private $jwt;
    private $sessionCookie;

    public function __construct(JwtWrapper $jwt, Cookie $sessionCookie)
    {
        $this->jwt = $jwt;
        $this->sessionCookie = $sessionCookie;
    }

    public function login(array $info)
    {
        $token = $this->jwt->encode($info);
        return [
            'name' => $this->sessionCookie->getName(),
            'value' => $this->sessionCookie->set($token)
        ];
    }

    public function isLoggedIn($key = 'id')
    {
        try {
            $token = $this->sessionCookie->get();
            if (!$token) {
                throw new Exception('Usuário não logado');
            }
            return $this->jwt->decode($token)->data->$key;
        } catch (Exception $e) {
        }

        return false;
    }

    public function logout()
    {
        $this->sessionCookie->remove();
    }
}
