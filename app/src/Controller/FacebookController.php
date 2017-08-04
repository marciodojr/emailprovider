<?php


namespace IntecPhp\Controller;


use IntecPhp\Model\FacebookHandler;

class FacebookController
{

    public static function page()
    {
        $fbHandler = new FacebookHandler();
        $accessToken = $fbHandler->getAccessToken();

        return [
            'accessToken' => $accessToken
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

}
