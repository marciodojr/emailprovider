<?php

namespace Mdojr\EmailProvider\Test\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Controller\VirtualAliasController;
use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;

class VirtualAliasControllerTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testListAll()
    {
        $fetchAllArr = [
            [
                'id' => 3,
                'source' => 'somesource1@email.com',
                'destination' => 'somedestination1@email.com',
            ],
            [
                'id' => 5,
                'source' => 'somesource2@email.com',
                'destination' => 'somedestination2@email.com',
            ]
        ];
        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 200, 'ok', $fetchAllArr);

        $mockRequest = $this->createMock(Request::class);
        $stubbedAlias = $this->createMock(VirtualAlias::class);
        $stubbedAlias
            ->method('fetchAll')
            ->willReturn($fetchAllArr);
        $jsonResponse = (new VirtualAliasController($stubbedAlias))->listAll($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInListAll()
    {
        $response = new Response();
        $message = 'An exception message';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $mockRequest = $this->createMock(Request::class);
        $stubbedAlias = $this->createMock(VirtualAlias::class);
        $stubbedAlias
            ->method('fetchAll')
            ->will($this->throwException(new Exception($message)));
        $jsonResponse = (new VirtualAliasController($stubbedAlias))->listAll($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testCreate()
    {
        $createArr = [
            'sourceId' => 1,
            'destination' => 'somedestination1@email.com',
        ];

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 200, 'ok', $createArr);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($createArr);

        $stubbedAlias = $this->createMock(VirtualAlias::class);
        $stubbedAlias
            ->method('create')
            ->with($createArr['sourceId'], $createArr['destination'])
            ->willReturn($createArr);

        $jsonResponse = (new VirtualAliasController($stubbedAlias))->create($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInCreate()
    {
        $response = new Response();
        $message = 'Email de origem ou alias não informado';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedAlias = $this->createMock(VirtualAlias::class);
        $stubbedAlias
            ->method('create')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new VirtualAliasController($stubbedAlias))->create($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testDelete()
    {
        $arr = [
            'aliases' => [10, 11, 12]
        ];

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 204, 'ok');

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($arr);

        $stubbedAlias = $this->createMock(VirtualAlias::class);
        $stubbedAlias
            ->method('delete')
            ->with($arr['aliases'])
            ->willReturn($arr);

        $jsonResponse = (new VirtualAliasController($stubbedAlias))->delete($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInDelete()
    {
        $arr = [
            'aliases' => [10, 11, 12]
        ];
        $response = new Response();
        $message = 'a delete exception message';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($arr);

        $stubbedAlias = $this->createMock(VirtualAlias::class);
        $stubbedAlias
            ->method('delete')
            ->with($arr['aliases'])
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new VirtualAliasController($stubbedAlias))->delete($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoAliasesInDelete()
    {
        $response = new Response();
        $message = 'Nenhum alias foi informado';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedAlias = $this->createMock(VirtualAlias::class);
        $stubbedAlias
            ->method('delete')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new VirtualAliasController($stubbedAlias))->delete($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
