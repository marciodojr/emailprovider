<?php

namespace Mdojr\EmailProvider\Service;

use Mdojr\EmailProvider\Service\JwtWrapper;
use Mdojr\EmailProvider\Service\Cookie;
use Exception;

class Account
{
    private $jwt;
    private $sessionCookie;
    private $accountData;

    public function __construct(JwtWrapper $jwt, Cookie $sessionCookie)
    {
        $this->jwt = $jwt;
        $this->sessionCookie = $sessionCookie;
        $this->accountData = null;
    }

    public function login(array $info)
    {
        $token = $this->jwt->encode($info);
        return [
            'name' => $this->sessionCookie->getName(),
            'value' => $token
        ];
    }

    public function get(string $key)
    {
        try {
            $token = $this->sessionCookie->get();
            if (!$token) {
                throw new Exception('Usuário não logado');
            }

            if(is_null($this->accountData)) {
                $data = $this->jwt->decode($token)->data;
                $this->accountData = $data;
            }

            return property_exists($this->accountData, $key) ? $this->accountData->$key : false;
        } catch (Exception $e) {
            return false;
        }
    }
}
