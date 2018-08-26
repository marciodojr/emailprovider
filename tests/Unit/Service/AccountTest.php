<?php

namespace Mdojr\EmailProvider\Test\Unit\Service;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\JwtWrapper;
use Mdojr\EmailProvider\Service\Account;
use Exception;

class AccountTest extends TestCase
{

    public function testLogin()
    {
        $arr = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
        ];
        $token = 'someMagicToken';
        $jwtStub = $this->createMock(JwtWrapper::class);
        $jwtStub
            ->method('encode')
            ->with($arr)
            ->willReturn($token);

        $account = new Account($jwtStub);
        $this->assertSame($token, $account->login($arr));
    }

    public function testGet()
    {
        $arr = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
        ];
        $token = 'someMagicToken';
        $jwtStub = $this->createMock(JwtWrapper::class);
        $jwtStub
            ->method('decode')
            ->with($token)
            ->willReturn((object)[
                'data' => (object)$arr
            ]);



        $account = new Account($jwtStub);

        $result = $account->get($token);

        $this->assertEquals((object)$arr, $result);
        $this->assertEquals($arr['key1'], $account->get($token, 'key1'));
        $this->assertEquals($arr['key2'], $account->get($token, 'key2'));
        $this->assertEquals($arr['key3'], $account->get($token, 'key3'));
        $this->assertSame(false, $account->get($token, 'invalid_key'));
    }

    public function testGetWithInvalidToken()
    {
        $arr = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
        ];
        $token = 'invalid_token';
        $jwtStub = $this->createMock(JwtWrapper::class);
        $jwtStub
            ->method('decode')
            ->with($token)
            ->will($this->throwException(new Exception()));

        $account = new Account($jwtStub);
        $this->assertSame(false, $account->get($token, 'invalid_key'));
    }

}
