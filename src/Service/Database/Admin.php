<?php

namespace Mdojr\EmailProvider\Service\Database;

use Mdojr\EmailProvider\Service\Database\Helper\AbstractDbProvider;
use Mdojr\EmailProvider\Entity\Admin as AdminEntity;
use Exception;

class Admin extends AbstractDbProvider
{
    public function searchByUsername(string $username)
    {
        $admin = $this->em->getRepository(AdminEntity::class)->findOneBy([
            'username' => $username,
            'isActive' => true
        ]);

        if(!$admin) {
            throw new Exception('Usuário não encontrado');
        }

        return $admin->getArrayCopy();
    }
}
