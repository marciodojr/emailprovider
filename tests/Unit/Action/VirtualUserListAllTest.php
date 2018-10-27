<?php

namespace Mdojr\EmailProvider\Test\Unit\Action;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Action\VirtualUserListAll;

class VirtualUserListAllTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testListAll()
    {
        $fetchAllArr = [
            [
                'id' => 3,
                'email' => 'someemail1@email.com',
            ],
            [
                'id' => 5,
                'email' => 'someemail2@email.com',
            ],
            [
                'id' => 7,
                'email' => 'someemail3@email.com',
            ],
        ];
        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 200, 'ok', $fetchAllArr);

        $mockRequest = $this->createMock(Request::class);
        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('fetchAll')
            ->willReturn($fetchAllArr);
        $jsonResponse = (new VirtualUserListAll($stubbedEmail))->__invoke($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testThrowExceptionInListAll()
    {
        $response = new Response();
        $message = 'An exception message';
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $mockRequest = $this->createMock(Request::class);
        $stubbedEmail = $this->createMock(VirtualUser::class);
        $stubbedEmail
            ->method('fetchAll')
            ->will($this->throwException(new Exception($message)));
        $jsonResponse = (new VirtualUserListAll($stubbedEmail))->__invoke($mockRequest, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
