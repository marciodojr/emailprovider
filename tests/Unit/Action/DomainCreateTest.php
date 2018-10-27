<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\DomainCreate;

class DomainCreateTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testCreate()
    {
        $createArr = [
            'id' => 10,
            'name' => 'mydomain.org'
        ];

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 200, 'ok', $createArr);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn(['name' => $createArr['name']]);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('create')
            ->with($createArr['name'])
            ->willReturn($createArr);

        $jsonResponse = (new DomainCreate($stubbedDomain))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInCreate()
    {
        $response = new Response();
        $message = 'a create exception message';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn(['name' => 'some domain']);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('create')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainCreate($stubbedDomain))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoNameInCreate()
    {
        $response = new Response();
        $message = 'Domínio não informado';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('create')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainCreate($stubbedDomain))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
