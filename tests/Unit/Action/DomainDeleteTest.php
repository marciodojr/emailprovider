<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\DomainDelete;

class DomainDeleteTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testDelete()
    {
        $arr = [
            'domains' => [10, 11, 12]
        ];

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 204, 'ok');

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($arr);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('delete')
            ->with($arr['domains'])
            ->willReturn($arr);

        $jsonResponse = (new DomainDelete($stubbedDomain))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInDelete()
    {
        $arr = [
            'domains' => [10, 11, 12]
        ];
        $response = new Response();
        $message = 'a delete exception message';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($arr);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('delete')
            ->with($arr['domains'])
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainDelete($stubbedDomain))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoDomainsInDelete()
    {
        $response = new Response();
        $message = 'Nenhum domínio foi informado';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('delete')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainDelete($stubbedDomain))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
