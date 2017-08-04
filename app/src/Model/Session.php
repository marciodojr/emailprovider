<?php


namespace IntecPhp\Model;

class Session
{
    // Instância da classe
    private static $instance = null;

    // Construtor privado: só a própria classe pode invocá-lo
    private function __construct()
    {
        self::start();
    }

    public static function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function unset($key)
    {
        unset($_SESSION[$key]);
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }

    public function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    private function __clone()
    {

    }

    private function __wakeup()
    {

    }
}
