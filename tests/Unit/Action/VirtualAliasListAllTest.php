<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\VirtualAliasListAll;

class VirtualAliasListAllTest extends TestCase
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
        $jsonResponse = (new VirtualAliasListAll($stubbedAlias))->__invoke($mockRequest, $response);

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
        $jsonResponse = (new VirtualAliasListAll($stubbedAlias))->__invoke($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
