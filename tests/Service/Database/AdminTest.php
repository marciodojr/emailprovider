<?php

namespace Mdojr\EmailProvider\Tests\Service\Database;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\Admin;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Mdojr\EmailProvider\Entity\Admin as AdminEntity;
use Exception;

class AdminTest extends TestCase
{
    public function testSearchByUsernameSuccess()
    {
        $userName = 'hello!';
        $admin = [
            'id' => null,
            'username' => null,
            'password' => null,
            'isActive' => true
        ];

        $stubRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stubRepository
            ->method('findOneBy')
            ->with([
                'username' => $userName,
                'isActive' => true
            ])
            ->willReturn(new AdminEntity);

        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->method('getRepository')
            ->with(AdminEntity::class)
            ->willReturn($stubRepository);

        $adminService = new Admin($stubEm);
        $resultArr = $adminService->searchByUsername($userName);

        $this->assertEquals($admin, $resultArr);
    }

    public function testSearchByUsernameError()
    {
        $userName = 'hello!';

        $stubRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stubRepository
            ->method('findOneBy')
            ->with([
                'username' => $userName,
                'isActive' => true
            ])
            ->willReturn(null);

        $stubEm = $this->createMock(EntityManager::class);
        $stubEm
            ->method('getRepository')
            ->with(AdminEntity::class)
            ->willReturn($stubRepository);

        $adminService = new Admin($stubEm);

        $this->expectExceptionMessage('Usuário não encontrado');
        $adminService->searchByUsername($userName);
    }
}
