<?php

namespace Mdojr\EmailProvider\Service\Database;

use Mdojr\EmailProvider\Entity\VirtualDomains;
use Mdojr\EmailProvider\Entity\VirtualUsers;
use Mdojr\EmailProvider\Service\Database\Helper\AbstractDbProvider;

class VirtualUser extends AbstractDbProvider
{
    public function fetchAll()
    {
        $res = $this->em->getRepository(VirtualUsers::class)->findAll();
        return array_map(function ($el) {
            return $el->getArrayCopy();
        }, $res);
    }

    public function create(string $email, string $password, int $domainId)
    {
        $domain = $this->em->find(VirtualDomains::class, $domainId);
        $sql = 'INSERT INTO virtual_users VALUES(null, ?, ENCRYPT(?, CONCAT(\'$6$\', SUBSTRING(SHA(RAND()), -16))), ?)';
        $conn = $this->em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$domainId, $password, $email . '@'. $domain->name]);

        $vuId = $conn->lastInsertId();
        $vuser = $this->em->find(VirtualUsers::class, $vuId);
        return $vuser->getArrayCopy();
    }

    public function delete(array $ids)
    {
        foreach($ids as $id)  {
            $vuser = $this->em->getReference(VirtualUsers::class, $id);
            $this->em->remove($vuser);
        }
        $this->em->flush();
    }
}
