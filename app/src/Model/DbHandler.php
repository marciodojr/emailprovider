<?php

namespace IntecPhp\Model;

/**
 * Faz a manipulação do banco de dados da aplicação
 *
 * @author intec
 */
class DbHandler
{

    // Instância da classe
    private static $instance = null;
    private $conn;

    // Construtor privado: só a própria classe pode invocá-lo
    private function __construct()
    {
        try {

            $host = getenv('DB_HOST');
            $db = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');
            $charset = getenv('DB_CHARSET');

            $this->conn = mysqli_connect($host, $user, $pass, $db);
            $this->conn->set_charset($charset);
        } catch (\Exception $e) {
            Log::write($e->getMessage(), __METHOD__);
            die("Erro na conexão com o banco de dados.");
        }
    }

    // método estático
    public static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new static();
        }

        return self::$instance->conn;
    }

    private function __clone()
    {

    }

    private function __wakeup()
    {

    }
}
