<?php

namespace Mdojr\EmailProvider\Service;

use Mdojr\EmailProvider\Service\Database\Admin;

class Auth
{
    private $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function validate(string $username, string $password)
    {
        $adm = $this->admin->searchByUsernameActive($username, true);

        if($this->validatePassword($password, $adm['password'])) {
            return $adm['id'];
        }
    }

    private function validatePassword(string $pass, string $encryptedPass)
    {
        return password_verify($pass, $encryptedPass);
    }

}
