<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\VirtualAliasCreate;

class VirtualAliasCreateTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

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

        $jsonResponse = (new VirtualAliasCreate($stubbedAlias))->__invoke($stubbedRequest, $response);
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

        $jsonResponse = (new VirtualAliasCreate($stubbedAlias))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
