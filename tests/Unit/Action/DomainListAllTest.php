<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\DomainListAll;

class DomainListAllTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testListAll()
    {
        $fetchAllArr = [
            [
                'id' => 1,
                'name' => 'jhonny.com'
            ],
            [
                'id' => 2,
                'name' => 'alwayswannafly.com'
            ]
        ];
        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 200, 'ok', $fetchAllArr);

        $mockRequest = $this->createMock(Request::class);
        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('fetchAll')
            ->willReturn($fetchAllArr);
        $jsonResponse = (new DomainListAll($stubbedDomain))->__invoke($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInListAll()
    {
        $response = new Response();
        $message = 'An exception message';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $mockRequest = $this->createMock(Request::class);
        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('fetchAll')
            ->will($this->throwException(new Exception($message)));
        $jsonResponse = (new DomainListAll($stubbedDomain))->__invoke($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
