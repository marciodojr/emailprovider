<?php

namespace IntecPhp\Model;


use IntecPhp\Model\EmailWrapper;
use IntecPhp\Model\Config;

class Notify
{
    public static function simpleEmail($toName, $toEmail, $subject, $message)
    {
        $em = new EmailWrapper(Config::class, $subject, $toName, $toEmail, $message, false);
        $em->send();
    }
}
