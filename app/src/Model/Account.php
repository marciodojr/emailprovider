<?php


namespace IntecPhp\Model;


use Intec\Session\Session;

class Account
{

    public static function login($id)
    {
        $session = Session::getInstance();
        $session->set('id', $id);
    }

	public static function getCurrentUserId() {
		$session = Session::getInstance();
		return $session->get('id');
	}

    public static function isLoggedIn()
    {
        $session = Session::getInstance();
        return $session->exists('id');
    }

    public static function logout()
    {
        $session = Session::getInstance();
        $session->unset('id');
    }

}
