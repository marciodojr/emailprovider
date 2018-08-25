<?php

namespace Mdojr\EmailProvider\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Controller\DomainController;
use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;

class DomainControllerTest extends TestCase
{
    use \Mdojr\EmailProvider\Tests\ResponseTestCase;

    public function testCreateInstance()
    {
        $fakeDomain = $this->createMock(VirtualDomain::class);
        $controller = new DomainController($fakeDomain);
        $this->assertInstanceOf(DomainController::class, $controller);
    }

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
        $jsonResponse = (new DomainController($stubbedDomain))->listAll($mockRequest, $response);

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
        $jsonResponse = (new DomainController($stubbedDomain))->listAll($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

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

        $jsonResponse = (new DomainController($stubbedDomain))->create($stubbedRequest, $response);
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

        $jsonResponse = (new DomainController($stubbedDomain))->create($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoNameInCreate()
    {
        $response = new Response();
        $message = 'Undefined index: name';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('create')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainController($stubbedDomain))->create($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testUpdate()
    {
        $args = [
            'id' => 30
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
            ->with($args['id'], $arr['name'])
            ->willReturn($data);

        $jsonResponse = (new DomainController($stubbedDomain))->update($stubbedRequest, $response, $args);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInUpdate()
    {
        $args = [
            'id' => 30
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
            ->with($args['id'], $arr['name'])
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainController($stubbedDomain))->update($stubbedRequest, $response, $args);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoNameInUpdate()
    {
        $args = [
            'id' => 30
        ];

        $message = 'Undefined index: name';

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('update')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainController($stubbedDomain))->update($stubbedRequest, $response, $args);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

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

        $jsonResponse = (new DomainController($stubbedDomain))->delete($stubbedRequest, $response);
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

        $jsonResponse = (new DomainController($stubbedDomain))->delete($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoDomainsInDelete()
    {
        $response = new Response();
        $message = 'Undefined index: domains';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedDomain = $this->createMock(VirtualDomain::class);
        $stubbedDomain
            ->method('delete')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new DomainController($stubbedDomain))->delete($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
