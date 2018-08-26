<?php

namespace Mdojr\EmailProvider\Test\Unit\Service;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\Admin;
use Mdojr\EmailProvider\Service\Auth;

class AuthTest extends TestCase
{
    public function testVerifyPassword()
    {
        $mock = $this->createMock(Auth::class);
        $reflection = new \ReflectionClass(Auth::class);
        $method = $reflection->getMethod('verifyPassword');
        $method->setAccessible(true);

        $password = '123456789';
        $correctEncryptedPass = password_hash($password, PASSWORD_BCRYPT);
        $wrongEncryptedPass = 'aaaaaa';

        $this->assertTrue($method->invokeArgs($mock, [$password, $correctEncryptedPass]));
        $this->assertFalse($method->invokeArgs($mock, [$password, $wrongEncryptedPass]));
    }

    public function testValidate()
    {
        $id = 10;
        $username = 'helloworld';
        $password = 'secret';
        $correctEncryptedPass = password_hash($password, PASSWORD_BCRYPT);
        $wrongEncryptedPass = 'aaaaaa';

        $adminStub = $this->createMock(Admin::class);
        $adminStub
            ->method('searchByUsername')
            ->with($username)
            ->willReturn([
                'id' => $id,
                'password' => $correctEncryptedPass
            ]);

        $auth = new Auth($adminStub);
        $this->assertSame($id, $auth->validate($username, $password));
        $this->assertNull($auth->validate($username, '???'));
    }
}
