<?php


namespace IntecPhp\Controller;


use IntecPhp\Model\DbHandler;

class HelloController
{
    public static function index()
    {

        $dbh = DbHandler::getInstance();
        $stmt = $dbh->prepare('select * from start where id in(:id1, :id2)', [':id1' => 1, ':id2' => 3]);
        if($stmt) {
            while($row = $stmt->fetch()) {
                print_r($row);
            }
            exit;
        }

        return 'Hello';
    }
}
