<?php

namespace Mdojr\EmailProvider\Tests\Entity;

use Mdojr\EmailProvider\Entity\VirtualUsers;
use Mdojr\EmailProvider\Entity\VirtualDomains;
use Mdojr\EmailProvider\Entity\Helper\ArrayCopy;
use PHPUnit\Framework\TestCase;

class VirtualUsersTest extends TestCase
{
    public function testArrayCopy()
    {
        $arr = [
            'id' => 1,
            'email' => 'email@gmail.com',
        ];
        $password = 'somesecret';

        $fakeDomain = $this->createMock(VirtualDomains::class);
        $email = new VirtualUsers(
            $arr['email'],
            $password,
            $fakeDomain
        );

        $reflection = new \ReflectionClass(VirtualUsers::class);
        $idProperty = $reflection->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue($email, $arr['id']);

        $this->assertInstanceOf(ArrayCopy::class, $email);
        $this->assertEquals($arr, $email->getArrayCopy());
    }

    public function testGetPassword()
    {
        $email = 'someemail@gmail.com';
        $password = 'somesecret';

        $fakeDomain = $this->createMock(VirtualDomains::class);
        $email = new VirtualUsers(
            $email,
            $password,
            $fakeDomain
        );

        $this->assertSame($password, $email->password);
    }
}
