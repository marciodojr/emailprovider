<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\VirtualAliasDelete;

class VirtualAliasDeleteTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

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

        $jsonResponse = (new VirtualAliasDelete($stubbedAlias))->__invoke($stubbedRequest, $response);
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

        $jsonResponse = (new VirtualAliasDelete($stubbedAlias))->__invoke($stubbedRequest, $response);
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

        $jsonResponse = (new VirtualAliasDelete($stubbedAlias))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
