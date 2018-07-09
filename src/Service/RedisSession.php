<?php

namespace Mdojr\EmailProvider\Service;

use Redis;

final class RedisSession
{

    private $redis;
    private $cookieName;
    private $timeout;
    private $cookieValue;

    public function __construct(Redis $redis, string $cookieName, int $timeout)
    {
        $this->redis = $redis;
        $this->cookieName = $cookieName;
        $this->timeout = $timeout;
        $this->cookieValue = null;
    }

    public function get(string $key)
    {
        if ($cookieValue = $this->getCookieValue()) {
            return $this->redis->hGet($cookieValue, $key);
        }
    }

    public function exists(string $key)
    {
        if ($cookieValue = $this->getCookieValue()) {
            $this->removeCookie();
            $this->redis->hExists($cookieValue, $key);
        }
    }

    public function set(string $key, $value)
    {
        $cookieValue = $this->generateCookieValue();
        if ($this->setCookieValue($cookieValue)) {
            $this->redis->hSet($cookieValue, $key, $value);
            $this->redis->setTimeout($cookieValue, $this->expirationTime());
        }
        return $cookieValue;
    }

    public function unset(string $key)
    {
        if ($cookieValue = $this->getCookieValue()) {
            $this->removeCookie();
            $this->redis->hDel($cookieValue, $key);
        }
    }

    private function setCookieValue(string $cookieValue)
    {
        if (setcookie($this->cookieName, $cookieValue, $this->expirationTime(), '/')) {
            $this->cookieValue = $cookieValue;
            return $cookieValue;
        }
    }

    private function removeCookie()
    {
        $this->cookieValue = null;
        return setcookie($this->cookieName, '', -1, '/');
    }

    private function getCookieValue()
    {
        return $this->cookieValue = $this->cookieValue ?? filter_input(INPUT_COOKIE, $this->cookieName);
    }

    private function generateCookieValue()
    {
        return bin2hex(random_bytes(16));
    }

    private function expirationTime()
    {
        return time() + $this->timeout;
    }
}
