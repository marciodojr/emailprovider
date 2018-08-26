<?php

namespace Mdojr\EmailProvider\Test\Unit\Service\Database;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Mdojr\EmailProvider\Entity\VirtualDomains;
use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Exception;

class VirtualDomainTest extends TestCase
{
    public function testFetchAll()
    {
        $arr = [
            [
                'id' => 10,
                'name' => 'somedomain2.com.br'
            ],
            [
                'id' => 13,
                'name' => 'somedomain3.com.br'
            ],
            [
                'id' => 16,
                'name' => 'somedomain4.com.br'
            ],
        ];
        $entArr =  $this->createDomainArr($arr);

        $stubRepository = $this->createMock(EntityRepository::class);
        $stubRepository
            ->method('findAll')
            ->willReturn($entArr);

        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->method('getRepository')
            ->with(VirtualDomains::class)
            ->willReturn($stubRepository);

        $virtualDomain = new VirtualDomain($stubEm);
        $this->assertEquals($arr, $virtualDomain->fetchAll());
    }

    public function testCreate()
    {
        $domain = $this->createDomain(10, 'somedomain.com');

        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->expects($this->once())
            ->method('persist');
        $stubEm
            ->expects($this->once())
            ->method('flush');

        $virtualDomain = new VirtualDomain($stubEm);
        $this->assertEquals($domain->name, $virtualDomain->create($domain->name)['name']);
    }

    public function testUpdate()
    {
        $domain = $this->createDomain(10, 'somedomain.com');

        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->expects($this->once())
            ->method('getReference')
            ->with(VirtualDomains::class, $domain->id)
            ->willReturn($domain);
        $stubEm
            ->expects($this->once())
            ->method('persist');
        $stubEm
            ->expects($this->once())
            ->method('flush');

        $virtualDomain = new VirtualDomain($stubEm);
        $this->assertEquals(
            [
                'id' => $domain->id,
                'name' => 'anotherDomain.com'
            ],
            $virtualDomain->update($domain->id, 'anotherDomain.com')
        );
    }

    public function testUpdateException()
    {
        $domainId = 5;
        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->expects($this->once())
            ->method('getReference')
            ->with(VirtualDomains::class, $domainId)
            ->willReturn(null);

        $virtualDomain = new VirtualDomain($stubEm);
        $this->expectExceptionMessage('Domínio não encontrado');
        $virtualDomain->update($domainId, 'anotherDomain.com');
    }

    public function testDelete()
    {
        $arr = [
            [
                'id' => 10,
                'name' => 'somedomain2.com.br'
            ],
            [
                'id' => 13,
                'name' => 'somedomain3.com.br'
            ],
            [
                'id' => 16,
                'name' => 'somedomain4.com.br'
            ],
        ];
        $entArr = $this->createDomainArr($arr);
        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->expects($this->exactly(3))
            ->method('getReference')
            ->withConsecutive(
                [VirtualDomains::class, $arr[0]['id']],
                [VirtualDomains::class, $arr[1]['id']],
                [VirtualDomains::class, $arr[2]['id']]
            )
            ->willReturnOnConsecutiveCalls($entArr[0], $entArr[1], $entArr[2]);

        $stubEm
            ->expects($this->once())
            ->method('flush');

        $virtualDomain = new VirtualDomain($stubEm);
        $virtualDomain->delete([$arr[0]['id'], $arr[1]['id'], $arr[2]['id']]);
    }

    private function createDomain($id, $name)
    {
        $domain = new VirtualDomains($name);

        $reflection = new \ReflectionClass(VirtualDomains::class);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($domain, $id);

        return $domain;
    }

    private function createDomainArr($arr)
    {
        $entArr = [];
        foreach($arr as $ar) {
            $entArr[] = $this->createDomain($ar['id'], $ar['name']);
        }

        return $entArr;
    }
}
