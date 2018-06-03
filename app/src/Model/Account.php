<?php

namespace IntecPhp\Model;

use Predis\Client as RedisClient;

final class Account
{
    private $redis;
    private $cookieName;
    private $timeout;
    private $cookieValue;

    public function __construct(RedisClient $redis, string $cookieName, int $timeout)
    {
        $this->redis = $redis;
        $this->cookieName = $cookieName;
        $this->timeout = $timeout;
        $this->cookieValue = null;
    }

    public function login($id)
    {
        $cookieValue = $this->generateCookieValue();
        if ($this->setCookieValue($cookieValue)) {
            $this->redis->set($cookieValue, $id);
        }
    }

    public function isLoggedIn()
    {
        if ($cookieValue = $this->getCookieValue()) {
            return $this->redis->get($cookieValue);
        }
    }

    public function logout()
    {
        if ($cookieValue = $this->getCookieValue()) {
            $this->removeCookie();
            $this->redis->delete($cookieValue);
        }
    }

    private function setCookieValue(string $cookieValue)
    {
        if (setcookie($this->cookieName, $cookieValue, time() + $this->timeout)) {
            $this->cookieValue = $cookieValue;
            return $cookieValue;
        }
    }

    private function removeCookie()
    {
        $this->cookieValue = null;
        return setcookie($this->cookieName, '', -1);
    }

    private function getCookieValue()
    {
        return $this->cookieValue = $this->cookieValue ?? filter_input(INPUT_COOKIE, $this->cookieName);
    }

    private function generateCookieValue()
    {
        return bin2hex(random_bytes(16));
    }
}
