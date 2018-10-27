<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\DomainUpdate;

class DomainUpdateTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testUpdate()
    {
        $args = [
            'domainId' => 30
        ];
        $arr = [
            'name' => 'pingpong.com'
        ];
        $data = [
            'id' => $args['id'],
            'name' => $arr['name']
        ];

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 200, 'ok', $data);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($arr);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('update')
            ->with($args['domainId'], $arr['name'])
            ->willReturn($data);

        $jsonResponse = (new DomainUpdate($stubbedDomain))->__invoke($stubbedRequest, $response, $args['domainId']);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInUpdate()
    {
        $args = [
            'domainId' => 30
        ];
        $arr = [
            'name' => 'pingpong.com'
        ];

        $message = 'An update exception message';

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn($arr);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('update')
            ->with($args['domainId'], $arr['name'])
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainUpdate($stubbedDomain))->__invoke($stubbedRequest, $response, $args['domainId']);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoNameInUpdate()
    {
        $args = [
            'id' => 30
        ];

        $message = 'Domínio não informado';

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('update')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainUpdate($stubbedDomain))->__invoke($stubbedRequest, $response, $args);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
