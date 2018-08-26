<?php

namespace Mdojr\EmailProvider\Test\Unit\Service\Database;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Mdojr\EmailProvider\Entity\VirtualAliases;
use Mdojr\EmailProvider\Entity\VirtualDomains;
use Mdojr\EmailProvider\Entity\VirtualUsers;
use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Exception;

class VirtualAliasTest extends TestCase
{
    public function testFetchAll()
    {
        $arr = [
            [
                'id' => 10,
                'source' => 'source1@gmail.com.br',
                'destination' => 'destination1@gmail.com'

            ],
            [
                'id' => 13,
                'source' => 'source2@gmail.com.br',
                'destination' => 'destination2@gmail.com'

            ],
            [
                'id' => 14,
                'source' => 'source3@gmail.com.br',
                'destination' => 'destination3@gmail.com'

            ],
        ];
        $entArr =  $this->createAliasArr($arr);

        $stubRepository = $this->createMock(EntityRepository::class);
        $stubRepository
            ->method('findAll')
            ->willReturn($entArr);

        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->method('getRepository')
            ->with(VirtualAliases::class)
            ->willReturn($stubRepository);

        $virtualAlias = new VirtualAlias($stubEm);
        $this->assertEquals($arr, $virtualAlias->fetchAll());
    }

    public function testCreate()
    {
        $sourceId = 10;
        $destId = 50;
        $source = 'somesource@gmail.com';
        $destination = 'dest@destination.com';
        $alias = $this->createAlias($destId, $source, $destination);

        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->expects($this->once())
            ->method('find')
            ->with(VirtualUsers::class, $sourceId)
            ->willReturn(new VirtualUsers($source, 'somepassword', new VirtualDomains('somedomain')));

        $stubEm
            ->expects($this->once())
            ->method('persist');

        $stubEm
            ->expects($this->once())
            ->method('flush');

        $virtualAlias = new VirtualAlias($stubEm);
        $this->assertEquals([
            'id' => null,
            'source' => $source,
            'destination' => $destination
        ], $virtualAlias->create($sourceId, $destination));
    }

    public function testCreateException()
    {
        $sourceId = 10;
        $destId = 50;
        $source = 'somesource@gmail.com';
        $destination = 'dest@destination.com';
        $alias = $this->createAlias($destId, $source, $destination);

        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->expects($this->once())
            ->method('find')
            ->with(VirtualUsers::class, $sourceId)
            ->willReturn(null);

        $virtualAlias = new VirtualAlias($stubEm);
        $this->expectException(Exception::class);
        $virtualAlias->create($sourceId, $destination);
    }

    public function testDelete()
    {
        $arr = [
            [
                'id' => 10,
                'source' => 'source1@gmail.com.br',
                'destination' => 'destination1@gmail.com'

            ],
            [
                'id' => 13,
                'source' => 'source2@gmail.com.br',
                'destination' => 'destination2@gmail.com'

            ],
            [
                'id' => 14,
                'source' => 'source3@gmail.com.br',
                'destination' => 'destination3@gmail.com'

            ],
        ];
        $entArr = $this->createAliasArr($arr);
        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->expects($this->exactly(3))
            ->method('getReference')
            ->withConsecutive(
                [VirtualAliases::class, $arr[0]['id']],
                [VirtualAliases::class, $arr[1]['id']],
                [VirtualAliases::class, $arr[2]['id']]
            )
            ->willReturnOnConsecutiveCalls($entArr[0], $entArr[1], $entArr[2]);

        $stubEm
            ->expects($this->once())
            ->method('flush');

        $virtualAlias = new VirtualAlias($stubEm);
        $virtualAlias->delete([$arr[0]['id'], $arr[1]['id'], $arr[2]['id']]);
    }

    private function createAlias($id, $source, $dest)
    {
        $alias = new VirtualAliases($source, $dest, new VirtualDomains('somedomain'));
        $reflection = new \ReflectionClass(VirtualAliases::class);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($alias, $id);

        return $alias;
    }

    private function createAliasArr($arr)
    {
        $entArr = [];
        foreach($arr as $ar) {
            $entArr[] = $this->createAlias($ar['id'], $ar['source'], $ar['destination']);
        }

        return $entArr;
    }
}
