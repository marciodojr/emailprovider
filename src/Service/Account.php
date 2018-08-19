<?php

namespace Mdojr\EmailProvider\Service;

use Mdojr\EmailProvider\Service\JwtWrapper;
use Exception;

class Account
{
    private $jwt;

    public function __construct(JwtWrapper $jwt)
    {
        $this->jwt = $jwt;
    }

    public function login(array $info)
    {
        return $this->jwt->encode($info);
    }

    public function get(string $token, string $key = null)
    {
        try {
            $data = $this->jwt->decode($token)->data;

            if(is_null($key)) {
                return $data;
            }

            return property_exists($data, $key) ? $data->$key : false;
        } catch (Exception $e) {
            return false;
        }
    }
}
