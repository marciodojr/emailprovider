<?php

namespace Mdojr\EmailProvider\Service;

use Mdojr\EmailProvider\Service\Database\Admin;
use Exception;

class Auth
{
    private $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function validate(string $username, string $password)
    {
        $adm = $this->admin->searchByUsername($username);

        if(!$adm) {
            throw new Exception('Usuário não encontrado');
        }

        if($this->verifyPassword($password, $adm['password'])) {
            return $adm['id'];
        }
    }

    private function verifyPassword(string $pass, string $encryptedPass)
    {
        return password_verify($pass, $encryptedPass);
    }

}
