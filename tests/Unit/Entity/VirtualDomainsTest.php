<?php

namespace Mdojr\EmailProvider\Test\Unit\Entity;

use Mdojr\EmailProvider\Entity\VirtualDomains;
use Mdojr\EmailProvider\Entity\Helper\ArrayCopy;
use PHPUnit\Framework\TestCase;

class VirtualDomainsTest extends TestCase
{
    public function testArrayCopy()
    {
        $arr = [
            'id' => 1,
            'name' => 'a crazy domain',
        ];

        $domain = new VirtualDomains($arr['name']);
        $reflection = new \ReflectionClass(VirtualDomains::class);
        $idProperty = $reflection->getProperty('id');

        $idProperty->setAccessible(true);
        $idProperty->setValue($domain, $arr['id']);

        $this->assertInstanceOf(ArrayCopy::class, $domain);
        $this->assertEquals($arr, $domain->getArrayCopy());
    }

    public function testSetName()
    {
        $name = 'test';
        $domain = new VirtualDomains($name);
        $name = 'anothertest';
        $domain->setName($name);

        $this->assertSame($name, $domain->name);
    }
}
