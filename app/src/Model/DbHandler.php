<?php


namespace IntecPhp\Model;


use PDO;
use PDOException;

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

            $this->conn = new PDO(
                'mysql:host='.$host.';dbname='.$db.';charset=' . $charset,
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => false,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (\Exception $e) {
            die("Erro na conexão com o banco de dados: ". $e->getMessage());
        }
    }

    // método estático
    public static function getInstance()
    {

        if (self::$instance == null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function beginTransaction()
    {
        return $this->conn->beginTransaction();
    }

    public function commit()
    {
        return $this->conn->commit();
    }

    public function query($sql)
    {
        try {
            return $this->conn->query($sql);
        } catch(PDOException $e) {
            if($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            error_log($e->getMessage());
        }
    }

    public function prepare($queryString, array $params)
    {
        try {
            $sth = $this->conn->prepare($queryString);
            $sth->execute($params);
            return $sth;
        } catch(PDOException $e) {
            if($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            error_log($e->getMessage());
        }
    }

    private function __clone()
    {

    }

    private function __wakeup()
    {

    }
}
