<?php

namespace Mdojr\EmailProvider\Tests\Service\Database;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\DBAL\Connection;
use Mdojr\EmailProvider\Entity\VirtualDomains;
use Mdojr\EmailProvider\Entity\VirtualUsers;
use Doctrine\DBAL\Driver\Statement;
use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Exception;

class VirtualUserTest extends TestCase
{
    public function testFetchAll()
    {
        $arr = [
            [
                'id' => 10,
                'email' => 'someemail@gmail.com'
            ],
            [
                'id' => 13,
                'email' => 'someemail@hotmail.com'
            ],
            [
                'id' => 16,
                'email' => 'someemail@outlook.com'
            ],
        ];
        $entArr =  $this->createVirtualUsersArr($arr);

        $stubRepository = $this->createMock(EntityRepository::class);
        $stubRepository
            ->method('findAll')
            ->willReturn($entArr);

        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->method('getRepository')
            ->with(VirtualUsers::class)
            ->willReturn($stubRepository);

        $virtualUser = new VirtualUser($stubEm);

        $this->assertEquals($arr, $virtualUser->fetchAll());
    }

    public function testCreate()
    {
        $domainName = 'testdomain';
        $email ='someEmail@testdomain';
        $password = 'somepassword';
        $domain = $this->createDomain($domainName);
        $virtualUserEntity = $this->createVirtualUser(599, $email, $password, $domain);

        $stmt = $this->createMock(Statement::class);
        $conn = $this->createMock(Connection::class);
        $conn
            ->method('prepare')
            ->willReturn($stmt);
        $conn
            ->method('lastInsertId')
            ->willReturn($virtualUserEntity->id);

        $em = $this->createMock(EntityManager::class);

        $em
            ->expects($this->exactly(2))
            ->method('find')
            ->withConsecutive([VirtualDomains::class, $domain->id], [VirtualUsers::class, $virtualUserEntity->id])
            ->willReturnOnConsecutiveCalls($domain, $virtualUserEntity);

        $em
            ->method('getConnection')
            ->willReturn($conn);

        $virtualUser = new VirtualUser($em);
        $resultArr = $virtualUser->create($email, $password, $domain->id);

        $this->assertEquals($virtualUserEntity->getArrayCopy(), $resultArr);
    }

    public function testDelete()
    {
        $arr = [
            [
                'id' => 10,
                'email' => 'someemail@gmail.com'
            ],
            [
                'id' => 13,
                'email' => 'someemail@hotmail.com'
            ],
            [
                'id' => 16,
                'email' => 'someemail@outlook.com'
            ],
        ];
        $entArr = $this->createVirtualUsersArr($arr);
        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->expects($this->exactly(3))
            ->method('getReference')
            ->withConsecutive(
                [VirtualUsers::class, $arr[0]['id']],
                [VirtualUsers::class, $arr[1]['id']],
                [VirtualUsers::class, $arr[2]['id']]
            )
            ->willReturnOnConsecutiveCalls($entArr[0], $entArr[1], $entArr[2]);

        $stubEm
            ->expects($this->once())
            ->method('flush');

        $vuser = new VirtualUser($stubEm);
        $vuser->delete([$arr[0]['id'], $arr[1]['id'], $arr[2]['id']]);
    }

    private function createDomain($domainName)
    {
        $domain = new VirtualDomains($domainName);

        $reflection = new \ReflectionClass(VirtualDomains::class);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($domain, 55);

        return $domain;
    }

    private function createVirtualUser($id, $email, $password, $domain)
    {
        $vu = new VirtualUsers($email, $password, $domain);

        $reflection = new \ReflectionClass(VirtualUsers::class);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($vu, $id);

        return $vu;
    }

    private function createVirtualUsersArr($arr)
    {
        $domain = $this->createDomain('somedomain');

        $entArr = [];
        foreach($arr as $ar) {
            $entArr[] = $this->createVirtualUser($ar['id'], $ar['email'], 'somePassword1', $domain);
        }

        return $entArr;
    }
}
