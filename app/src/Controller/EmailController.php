<?php


namespace IntecPhp\Controller;

use IntecPhp\Model\Notify;
use Intec\Router\Request;

class EmailController
{
    public static function simpleEmail(Request $request)
    {
        $params = $request->getQueryParams();
        Notify::simpleEmail($params['name'], $params['email'], $params['subject'], $params['message']);
    }
}
