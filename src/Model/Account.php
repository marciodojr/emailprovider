<?php

namespace Mdojr\EmailProvider\Model;

use Mdojr\EmailProvider\Service\RedisSession;

class Account
{
    const ID_KEY = 'ID_f67c2bcbfcfa30fccb36f72dca22a817';

    private $redisSession;

    public function __construct(RedisSession $redisSession)
    {
        $this->redisSession = $redisSession;
    }

    public function login($id)
    {
        $_SESSION['aaaa'] = $id;
        $this->redisSession->set(self::ID_KEY, $id);
    }

    public function isLoggedIn()
    {
        return $this->redisSession->get(self::ID_KEY);
    }

    public function logout()
    {
        $this->redisSession->unset(self::ID_KEY);
    }
}
