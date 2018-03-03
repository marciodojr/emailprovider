<?php

namespace IntecPhp\Model;

/**
 * Define constantes da aplicação
 *
 * @mstile-150x150author intec
 */
class Config
{

    private static $config = [];
    private static $domain = '';

    // específico do projeto
    public static $PROJECT_ID;
    public static $PROJECT_NAME;
    public static $GOOGLE_ANALYTICS_ID;

    // facebook app
    public static $FACEBOOK_APP_ID;
    public static $FACEBOOK_APP_SECRET;
    public static $FACEBOOK_API_VERSION;
    public static $FACEBOOK_ACCESS_TOKEN;
    public static $MODE;

    public static $META_KEYWORDS;
    public static $META_AUTHOR;
    public static $META_DESCRIPTION;
    public static $META_PHOTO;
    public static $META_NAME;

    public static $TITLE;

    public static $BLACK_LISTED_IPS;

    const MODE_DEV = 'dev';
    const MODE_PROD = 'prod';

    // public static $USER_PHOTO_PATH;
    // public static $DEFAULT_PHOTO;

    // para email
    public static $SMTP_SERVER;
    public static $SMTP_PORT;
    public static $EMAIL;
    public static $EMAIL_PASS;
    public static $EMAIL_NAME;
    public static $EMAIL_FROM;
    public static $EMAIL_BCC_NAME;
    public static $EMAIL_BCC_EMAIL;
    public static $EMAIL_SUBJECT_PREFIX;
    public static $SMTP_SSL;

    // public static $SALT;
    // public static $GOOGLE_MAPS_API_KEY;
    // public static $BLACK_LISTED_IPS;
    // public static $MIN_PASSWORD_LENGTH;
    // public static $MOIP_SANDBOX_APP_ID;
    // public static $MOIP_SANDBOX_ACCESS_TOKEN;
    // public static $MOIP_SANDBOX_SECRET;
    // public static $MOIP_SANDBOX_TOKEN;
    // public static $MOIP_SANDBOX_KEY;
    // public static $MOIP_PRODUCTION_APP_ID;
    // public static $MOIP_PRODUCTION_ACCESS_TOKEN;
    // public static $MOIP_PRODUCTION_TOKEN;
    // public static $MOIP_PRODUCTION_KEY;
    // public static $MOIP_PRODUCTION_DESCRIPTION;
    // public static $MOIP_PRODUCTION_SECRET;
    // public static $MOIP_REDIRECT_URI;
    // public static $LOGO_IMG;
    // public static $PAYMENT_NOTIFICATIONS_URI;
    // public static $PAYMENT_DESCRIPTION;
    // public static $PLATAFORM_PERCENTUAL;
    // public static $PRODUCT_DESCRIPTION;


    // esta classe não pode ser instanciada
    private function __construct()
    {

    }

    public static function init()
    {
        self::$PROJECT_ID = getenv('PROJECT_ID');
        self::$PROJECT_NAME = getenv('PROJECT_NAME');
        self::$GOOGLE_ANALYTICS_ID = getenv('GOOGLE_ANALYTICS_ID');

        self::$FACEBOOK_APP_ID = getenv('FACEBOOK_APP_ID');
        self::$FACEBOOK_APP_SECRET = getenv('FACEBOOK_APP_SECRET');
        self::$FACEBOOK_API_VERSION = getenv('FACEBOOK_API_VERSION');
        self::$FACEBOOK_ACCESS_TOKEN = getenv('FACEBOOK_ACCESS_TOKEN');

        self::$META_KEYWORDS = getenv('META_KEYWORDS');
        self::$META_AUTHOR = getenv('META_AUTHOR');
        self::$META_DESCRIPTION = getenv('META_DESCRIPTION');
        self::$META_PHOTO = getenv('META_PHOTO');
        self::$META_NAME = getenv('META_NAME');
        self::$TITLE = getenv('TITLE');

        self::$SMTP_SERVER = getenv('SMTP_SERVER');
        self::$SMTP_PORT = getenv('SMTP_PORT');
        self::$EMAIL = getenv('EMAIL');
        self::$EMAIL_PASS = getenv('EMAIL_PASS');
        self::$EMAIL_NAME = getenv('EMAIL_NAME');
        self::$EMAIL_FROM = getenv('EMAIL_FROM');
        self::$EMAIL_BCC_NAME = getenv('EMAIL_BCC_NAME');
        self::$EMAIL_BCC_EMAIL = getenv('EMAIL_BCC_EMAIL');
        self::$EMAIL_SUBJECT_PREFIX = getenv('EMAIL_SUBJECT_PREFIX');
        self::$SMTP_SSL = getenv('SMTP_SSL');

        self::$MODE = getenv('MODE');

        self::$BLACK_LISTED_IPS = getenv('BLACK_LISTED_IPS');
    }

    public function setConfig($config1, $config2 = [])
    {
        $this->config = array_merge($config1, $config2);
    }

    public static function getDomain($suffix = "")
    {
        if (empty(self::$domain)) {
            self::$domain = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'];
        }

        if($_SERVER['SERVER_PORT'] !== 80 && $_SERVER['SERVER_PORT'] !== 443) {
            self::$domain .= ':' . $_SERVER['SERVER_PORT'];
        }

        return self::$domain . $suffix;
    }

    public static function getPhotoUrl($img = "")
    {
        if (!empty($img) && file_exists('./public' . self::$USER_PHOTO_PATH . $img)) {
            return self::$USER_PHOTO_PATH . $img;
        }

        return self::$DEFAULT_PHOTO;
    }

    public static function isProduction()
    {
        return self::$MODE === self::MODE_PROD;
    }

    public static function notBlacklisted($ip = null)
    {

        if(!$ip) {
            $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        }

        return strstr($ip, self::$BLACK_LISTED_IPS) === false;
    }

    public static function getMetaPhotoUrl()
    {
        return self::getDomain(self::$META_PHOTO);
    }
}
