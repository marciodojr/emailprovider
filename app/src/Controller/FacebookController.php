<?php


namespace IntecPhp\Controller;


use IntecPhp\Model\FacebookHandler;
use IntecPhp\Model\Config;
use Intec\Router\Request;

class FacebookController
{

    public static function page()
    {
        $fbHandler = new FacebookHandler();

        return [
            'accessToken' => $fbHandler->getAccessToken()
        ];
    }

    public static function requestPageAccessToken()
    {
        $fbHandler = new FacebookHandler();
        $url = $fbHandler->requestAccessToken('/facebook/pages', FacebookHandler::permissionsForPages());

        echo json_encode([
            'url' => $url
        ]);
    }

    public static function getUserInfo(Request $request)
    {
        $userId = $request->getUrlParams()[0];

        $fbHandler = new FacebookHandler();
        $userGraphData = $fbHandler->getUserInfo($userId);

        var_dump($userGraphData);
    }

}
