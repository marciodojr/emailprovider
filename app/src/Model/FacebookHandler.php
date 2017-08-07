<?php



namespace IntecPhp\Model;


use Facebook\Facebook;
use Facebook\FacebookApp;
use Facebook\FacebookRequest;
use IntecPhp\Model\Config;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;

class FacebookHandler
{
    private $fb;
    private $fbApp;
    const METHOD_GET = 'GET';

    public function __construct()
    {

        $this->fb = new Facebook([
            'app_id' => Config::$FACEBOOK_APP_ID,
            'app_secret' => Config::$FACEBOOK_APP_SECRET,
            'default_graph_version' => Config::$FACEBOOK_API_VERSION,
        ]);
        $this->fbApp = new FacebookApp(Config::$FACEBOOK_APP_ID, Config::$FACEBOOK_APP_SECRET);
    }

    public function requestAccessToken($redirectUrl, array $permissions)
    {
        $helper = $this->fb->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl(Config::getDomain($redirectUrl), $permissions);
        return $loginUrl;
    }

    public function getAccessToken()
    {

        if(Config::$MODE === Config::MODE_DEV) {
            return Config::$FACEBOOK_ACCESS_TOKEN;
        }

        $helper = $this->fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
            return $accessToken;
        } catch(FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    public function getPageInfo($pageId, $accessToken = null)
    {

        if(!$accessToken) {
            $accessToken = $this->getAccessToken();
        }

        $request = new FacebookRequest(
          $this->fbApp,
          $accessToken,
          self::METHOD_GET,
          '/' . $pageId
        );

        $response = $request->execute();
        $graphObject = $response->getGraphObject();
    }

    public function getUserInfo($userId, $accessToken = null)
    {
        if(!$accessToken) {
            $accessToken = $this->getAccessToken();
        }

        try {
            $response = $this->fb->get('me?fields=id,accounts', $accessToken);
            return $response->getGraphObject();

        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

    public static function permissionsForPages()
    {
        return ['manage_pages', 'pages_show_list'];
    }

}
