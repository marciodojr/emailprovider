<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\VirtualUserCreate;

class VirtualUserCreateTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testCreate()
    {
        $createArr = [
            'id' => 7,
            'email' => 'someemail3@email.com',
            'domain' => 1,
            'password' => 'somepassword'
        ];

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 200, 'ok', $createArr);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($createArr);

        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('create')
            ->with($createArr['email'], $createArr['password'])
            ->willReturn($createArr);

        $jsonResponse = (new VirtualUserCreate($stubbedEmail))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInCreate()
    {
        $response = new Response();
        $message = 'Informe o email, a senha e o domínio';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('create')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new VirtualUserCreate($stubbedEmail))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
