<?php

namespace Mdojr\EmailProvider\Tests\Entity;

use Mdojr\EmailProvider\Entity\VirtualAliases;
use Mdojr\EmailProvider\Entity\VirtualDomains;
use Mdojr\EmailProvider\Entity\Helper\ArrayCopy;
use PHPUnit\Framework\TestCase;

class VirtualAliasesTest extends TestCase
{
    public function testArrayCopy()
    {
        $arr = [
            'id' => 1,
            'source' => 'email@gmail.com',
            'destination' => 'youremail@gmail.com',
        ];

        $fakeDomain = $this->createMock(VirtualDomains::class);
        $alias = new VirtualAliases(
            $arr['source'],
            $arr['destination'],
            $fakeDomain
        );

        $reflection = new \ReflectionClass(VirtualAliases::class);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($alias, $arr['id']);

        $this->assertInstanceOf(ArrayCopy::class, $alias);
        $this->assertEquals($arr, $alias->getArrayCopy());
    }
}
