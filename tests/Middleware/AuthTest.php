<?php

namespace Mdojr\EmailProvider\Tests\Middleware;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Middleware\Auth;
use Mdojr\EmailProvider\Service\Account;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

class AuthTest extends TestCase
{
    use \Mdojr\EmailProvider\Tests\ResponseTestCase;

    public function testBearerTokens()
    {
        $mock = $this
            ->getMockBuilder(Auth::class)
            ->disableOriginalConstructor()
            ->getMock();
        $reflection = new \ReflectionClass(get_class($mock));
        $method = $reflection->getMethod('getToken');
        $method->setAccessible(true);

        $this->assertNull($method->invokeArgs($mock, ['Beaar aaaaa']));
        $this->assertSame('aaaaa', $method->invokeArgs($mock, ['Bearer aaaaa']));
        $this->assertNull($method->invokeArgs($mock, ['Beaar aaa aa']));
    }

    public function testBlockInvalidToken()
    {
        $token = 'aninvalidtoken';
        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 403, 'Você não possui permissão para acessar este recurso');
        $env = Environment::mock();
        $req = Request::createFromEnvironment($env)->withHeader('Authorization', 'Bearer ' . $token);
        $stubAcc = $this->createMock(Account::class);
        $stubAcc
            ->method('get')
            ->with($token)
            ->willReturn(false);

        $auth = new Auth($stubAcc);
        $jsonResponse = $auth->process($req, $response, function($req, $resp) {
            return null;
        });

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testAllowValidToken()
    {
        $token = '==valid==token==';
        $response = new Response();
        $env = Environment::mock();
        $req = Request::createFromEnvironment($env)->withHeader('Authorization', 'Bearer ' . $token);
        $stubAcc = $this->createMock(Account::class);
        $stubAcc
            ->method('get')
            ->with($token)
            ->willReturn(true);

        $auth = new Auth($stubAcc);
        $testCase = $this;
        $returnResp = $auth->process($req, $response, function($req, $resp) use ($testCase, $token) {
            $testCase->assertSame($token, $req->getAttribute('token'));
            return $resp;
        });

        $this->assertSame($response, $returnResp);
    }
}