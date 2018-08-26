<?php

namespace Mdojr\EmailProvider\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Controller\VirtualUserController;
use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;

class VirtualUserControllerTest extends TestCase
{
    use \Mdojr\EmailProvider\Tests\ResponseTestCase;

    public function testListAll()
    {
        $fetchAllArr = [
            [
                'id' => 3,
                'email' => 'someemail1@email.com',
            ],
            [
                'id' => 5,
                'email' => 'someemail2@email.com',
            ],
            [
                'id' => 7,
                'email' => 'someemail3@email.com',
            ],
        ];
        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 200, 'ok', $fetchAllArr);

        $mockRequest = $this->createMock(Request::class);
        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('fetchAll')
            ->willReturn($fetchAllArr);
        $jsonResponse = (new VirtualUserController($stubbedEmail))->listAll($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInListAll()
    {
        $response = new Response();
        $message = 'An exception message';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $mockRequest = $this->createMock(Request::class);
        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('fetchAll')
            ->will($this->throwException(new Exception($message)));
        $jsonResponse = (new VirtualUserController($stubbedEmail))->listAll($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

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

        $jsonResponse = (new VirtualUserController($stubbedEmail))->create($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInCreate()
    {
        $response = new Response();
        $message = 'Undefined index: email';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('create')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new VirtualUserController($stubbedEmail))->create($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testDelete()
    {
        $arr = [
            'emails' => [10, 11, 12]
        ];

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 204, 'ok');

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($arr);

        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('delete')
            ->with($arr['emails'])
            ->willReturn($arr);

        $jsonResponse = (new VirtualUserController($stubbedEmail))->delete($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInDelete()
    {
        $arr = [
            'emails' => [10, 11, 12]
        ];
        $response = new Response();
        $message = 'a delete exception message';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($arr);

        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('delete')
            ->with($arr['emails'])
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new VirtualUserController($stubbedEmail))->delete($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoEmailsInDelete()
    {
        $response = new Response();
        $message = 'Undefined index: emails';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('delete')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new VirtualUserController($stubbedEmail))->delete($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
