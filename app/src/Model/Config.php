<?php

namespace IntecPhp\Model;

/**
 * Define constantes da aplicação
 *
 * @author intec
 */
class Config
{

    private static $config = [];
    private static $domain = '';

    // específico do projeto
    public static $PROJECT_ID;
    public static $PROJECT_NAME;
    public static $GOOGLE_ANALYTICS_ID;

    // public static $USER_PHOTO_PATH;
    // public static $DEFAULT_PHOTO;

    // para email
    // public static $SMTP_SERVER;
    // public static $SMTP_PORT;
    // public static $EMAIL;
    // public static $EMAIL_PASS;
    // public static $EMAIL_NAME;
    // public static $EMAIL_FROM;
    // public static $EMAIL_BCC_NAME;
    // public static $EMAIL_BCC_EMAIL;
    // public static $EMAIL_SUBJECT_PREFIX;
    // public static $SMTP_SSL;

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

        // self::$USER_PHOTO_PATH = getenv('USER_PHOTO_PATH');
        // self::$DEFAULT_PHOTO = getenv('DEFAULT_PHOTO');

        // para email
        // self::$SMTP_SERVER = getenv('SMTP_SERVER');
        // self::$SMTP_PORT = getenv('SMTP_PORT');
        // self::$EMAIL = getenv('EMAIL');
        // self::$EMAIL_PASS = getenv('EMAIL_PASS');
        // self::$EMAIL_NAME = getenv('EMAIL_NAME');
        // self::$EMAIL_FROM = getenv('EMAIL_FROM');
        // self::$EMAIL_BCC_NAME = getenv('EMAIL_BCC_NAME');
        // self::$EMAIL_BCC_EMAIL = getenv('EMAIL_BCC_EMAIL');
        // self::$EMAIL_SUBJECT_PREFIX = getenv('EMAIL_SUBJECT_PREFIX');
        // self::$SMTP_SSL = getenv('SMTP_SSL');

        // self::$SALT = getenv('SALT');
        // self::$GOOGLE_MAPS_API_KEY = getenv('GOOGLE_MAPS_API_KEY');
        // self::$BLACK_LISTED_IPS = getenv('BLACK_LISTED_IPS');
        // self::$MIN_PASSWORD_LENGTH = getenv('MIN_PASSWORD_LENGTH');
        // self::$MOIP_SANDBOX_APP_ID = getenv('MOIP_SANDBOX_APP_ID');
        // self::$MOIP_SANDBOX_ACCESS_TOKEN = getenv('MOIP_SANDBOX_ACCESS_TOKEN');
        // self::$MOIP_SANDBOX_SECRET = getenv('MOIP_SANDBOX_SECRET');
        // self::$MOIP_SANDBOX_TOKEN = getenv('MOIP_SANDBOX_TOKEN');
        // self::$MOIP_SANDBOX_KEY = getenv('MOIP_SANDBOX_KEY');
        // self::$MOIP_PRODUCTION_APP_ID = getenv('MOIP_PRODUCTION_APP_ID');
        // self::$MOIP_PRODUCTION_ACCESS_TOKEN = getenv('MOIP_PRODUCTION_ACCESS_TOKEN');
        // self::$MOIP_PRODUCTION_TOKEN = getenv('MOIP_PRODUCTION_TOKEN');
        // self::$MOIP_PRODUCTION_KEY = getenv('MOIP_PRODUCTION_KEY');
        // self::$MOIP_PRODUCTION_DESCRIPTION = getenv('MOIP_PRODUCTION_DESCRIPTION');
        // self::$MOIP_PRODUCTION_SECRET = getenv('MOIP_PRODUCTION_SECRET');
        // self::$MOIP_REDIRECT_URI = getenv('MOIP_REDIRECT_URI');
        // self::$LOGO_IMG = getenv('LOGO_IMG');
        // self::$PAYMENT_NOTIFICATIONS_URI = getenv('PAYMENT_NOTIFICATIONS_URI');
        // self::$PAYMENT_DESCRIPTION = getenv('PAYMENT_DESCRIPTION');
        // self::$PLATAFORM_PERCENTUAL = getenv('PLATAFORM_PERCENTUAL');
        // self::$PRODUCT_DESCRIPTION = getenv('PRODUCT_DESCRIPTION');
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
        return !preg_match('/teste|lan|localhost/', self::getDomain());
    }

    public static function notBlacklisted($ip = null)
    {

        if(!$ip) {
            $ip = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
        }

        return strstr($ip, self::$BLACK_LISTED_IPS) === false;
    }
}
