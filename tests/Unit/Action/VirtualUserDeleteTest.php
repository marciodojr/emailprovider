<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\VirtualUserDelete;

class VirtualUserDeleteTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

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

        $jsonResponse = (new VirtualUserDelete($stubbedEmail))->__invoke($stubbedRequest, $response);
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

        $jsonResponse = (new VirtualUserDelete($stubbedEmail))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoEmailsInDelete()
    {
        $response = new Response();
        $message = 'Nenhum email foi informado';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $stubbedRequest = $this->createMock(Request::class);
        $stubbedRequest->method('getParams')->willReturn([]);

        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('delete')
            ->will($this->throwException(new Exception($message)));

        $jsonResponse = (new VirtualUserDelete($stubbedEmail))->__invoke($stubbedRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
