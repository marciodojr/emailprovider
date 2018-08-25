<?php

namespace Mdojr\EmailProvider\Service\Database;

use Mdojr\EmailProvider\Entity\VirtualDomains;
use Mdojr\EmailProvider\Service\Database\Helper\AbstractDbProvider;

class VirtualDomain extends AbstractDbProvider
{
    public function fetchAll()
    {
        $res = $this->em->getRepository(VirtualDomains::class)->findAll();

        return array_map(function ($el) {
            return $el->getArrayCopy();
        }, $res);
    }

    public function create(string $domainName)
    {
        $domain = new VirtualDomains($domainName);
        $this->em->persist($domain);
        $this->em->flush();
        return $domain->getArrayCopy();
    }

    public function update(int $id, string $domainName)
    {
        $domain = $this->em->getReference(VirtualDomains::class, $id);
        if(!$domain) {
            throw new Exception('Domínio não encontrado');
        }
        $domain->setName($domainName);
        $this->em->persist($domain);
        $this->em->flush();
        return $domain->getArrayCopy();
    }

    public function delete(array $ids)
    {
        foreach($ids as $id) {
            $domain = $this->em->getReference(VirtualDomains::class, $id);
            $this->em->remove($domain);
        }

        $this->em->flush();
    }
}
