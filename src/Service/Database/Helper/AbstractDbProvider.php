<?php

namespace Mdojr\EmailProvider\Service\Database\Helper;

use Doctrine\ORM\EntityManager;

abstract class AbstractDbProvider
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
