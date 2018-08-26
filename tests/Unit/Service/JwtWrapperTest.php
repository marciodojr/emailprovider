<?php

namespace Mdojr\EmailProvider\Test\Unit\Service;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\JwtWrapper;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\BeforeValidException;
use UnexpectedValueException;

class JwtWrapperTest extends TestCase
{
    public function testEncode()
    {
        $jwt = new JwtWrapper('magicsecret', 10);
        $data = [
            'some' => 'data'
        ];
        $this->assertTrue(is_string($jwt->encode($data)));
    }

    public function testDecodeSuccess()
    {
        $jwt = new JwtWrapper('magicsecret', 10);
        $data = [
            'id' => 10,
            'some' => 'data'
        ];
        $token = $jwt->encode($data);
        $this->assertEquals($data, (array)$jwt->decode($token)->data);
    }

    public function testExpiredToken()
    {
        $jwt = new JwtWrapper('magicsecret', 0, -1);
        $data = [
            'id' => 10,
            'some' => 'data'
        ];

        $token = $jwt->encode($data);
        $this->expectException(ExpiredException::class);
        $this->assertEquals($data, (array)$jwt->decode($token)->data);
    }

    public function testBeforeValidToken()
    {
        $jwt = new JwtWrapper('magicsecret', 20, 10);
        $data = [
            'id' => 10,
            'some' => 'data'
        ];

        $token = $jwt->encode($data);
        $this->expectException(BeforeValidException::class);
        $this->assertEquals($data, (array)$jwt->decode($token)->data);
    }

    public function testInvalidToken()
    {
        $jwt = new JwtWrapper('magicsecret', 5000);
        $data = [
            'id' => 10,
            'some' => 'data'
        ];

        $token = $jwt->encode($data);
        $this->expectException(UnexpectedValueException::class);
        $this->assertEquals($data, (array)$jwt->decode('invalid token')->data);
    }
}
