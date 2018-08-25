<?php

namespace Mdojr\EmailProvider\Tests\Entity;

use Mdojr\EmailProvider\Entity\Admin;
use Mdojr\EmailProvider\Entity\Helper\ArrayCopy;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    public function testArrayCopy()
    {
        $admin = new Admin();
        $reflection = new \ReflectionClass(Admin::class);
        $idProperty = $reflection->getProperty('id');
        $usernameProperty = $reflection->getProperty('username');
        $passwordProperty = $reflection->getProperty('password');
        $isActiveProperty = $reflection->getProperty('isActive');

        $idProperty->setAccessible(true);
        $usernameProperty->setAccessible(true);
        $passwordProperty->setAccessible(true);
        $isActiveProperty->setAccessible(true);

        $arr = [
            'id' => 1,
            'username' => 'Márcio',
            'password' => 'very secret',
            'isActive' => true
        ];

        $idProperty->setValue($admin, $arr['id']);
        $usernameProperty->setValue($admin, $arr['username']);
        $passwordProperty->setValue($admin, $arr['password']);
        $isActiveProperty->setValue($admin, $arr['isActive']);

        $this->assertInstanceOf(ArrayCopy::class, $admin);
        $this->assertEquals($arr, $admin->getArrayCopy());
    }
}
