<?php

namespace Mdojr\EmailProvider\Test\Unit\Controller;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Controller\LoginController;
use Slim\Http\Request;
use Slim\Http\Response;
use Exception;
use Mdojr\EmailProvider\Service\Auth;
use Mdojr\EmailProvider\Service\Account;

class LoginControllerTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testLoginSuccess()
    {

        $userData = [
            'username' => 'marciotest@someemail.com',
            'password' => 'verypassword',
        ];
        $id = 999;
        $token = 'fakevalidtoken';

        $authStub = $this->createMock(Auth::class);
        $authStub
            ->method('validate')
            ->with($userData['username'], $userData['password'])
            ->willReturn($id);

        $accStub = $this->createMock(Account::class);
        $accStub
            ->method('login')
            ->with([
                'id' => $id
            ])
            ->willReturn($token);

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 200, 'Autenticado com sucesso', [
            'token' => $token
        ]);

        $mockRequest = $this->createMock(Request::class);
        $mockRequest
            ->method('getParams')
            ->willReturn($userData);

        $jsonResponse = (new LoginController($accStub, $authStub))->login($mockRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testLoginWrongUserOrPassword()
    {
        $message = 'Usuário ou senha incorreta';
        $userData = [
            'username' => 'marciotest@someemail.com',
            'password' => 'wrogpassword',
        ];
        $id = 998;

        $fakeAcc = $this->createMock(Account::class);
        $authStub = $this->createMock(Auth::class);
        $authStub
            ->method('validate')
            ->with($userData['username'], $userData['password'])
            ->willReturn(false);

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $mockRequest = $this->createMock(Request::class);
        $mockRequest
            ->method('getParams')
            ->willReturn($userData);

        $jsonResponse = (new LoginController($fakeAcc, $authStub))->login($mockRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }

    public function testNoParams()
    {
        $message = 'Informe o nome de usuário e a senha';

        $fakeAcc = $this->createMock(Account::class);
        $fakeAuth = $this->createMock(Auth::class);
        $mockRequest = $this->createMock(Request::class);
        $mockRequest->method('getParams')->willReturn([]);

        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 400, $message);

        $jsonResponse = (new LoginController($fakeAcc, $fakeAuth))->login($mockRequest, $response);
        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
