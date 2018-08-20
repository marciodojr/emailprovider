<?php

namespace Mdojr\EmailProvider\Service\Database;

use Mdojr\EmailProvider\Entity\VirtualAliases;
use Mdojr\EmailProvider\Entity\VirtualUsers;
use Mdojr\EmailProvider\Service\Database\Helper\AbstractDbProvider;
use Exception;

class VirtualAlias extends AbstractDbProvider
{

    public function fetchAll()
    {
        $res = $this->em->getRepository(VirtualAliases::class)->findAll();

        return array_map(function ($el) {
            return $el->getArrayCopy();
        }, $res);
    }

    public function create(string $sourceId, string $destination)
    {
        $virtualUser = $this->em->find(VirtualUsers::class, $sourceId);

        if(!$virtualUser) {
            throw new Exception('Email de origem não encontrado');
        }

        $alias = new VirtualAliases($virtualUser->email, $destination, $virtualUser->domain);

        $this->em->persist($alias);
        $this->em->flush();

        return $alias->getArrayCopy();
    }

    public function delete(array $ids)
    {
        foreach($ids  as $id) {
            $alias = $this->em->find(VirtualAliases::class, $id);
            $this->em->remove($alias);
        }
        $this->em->flush();
    }
}
