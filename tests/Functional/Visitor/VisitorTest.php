<?php

namespace Mdojr\EmailProvider\Test\Functional\Visitor;

use Mdojr\EmailProvider\Test\Functional\TestCase;
use Firebase\JWT\JWT;
use Exception;

class VisitorTest extends TestCase
{

    private $secret;

    public function setUp()
    {
        parent::setUp();
        $this->secret = $this->app->getContainer()->get('settings')['jwt']['app_secret'];
    }

    public function testResourceNotFound()
    {
        $response = $this->runApp('GET', '/');
        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals([
            'code' => 404,
            'message' => 'Recurso não encontrado',
            'data' => []
        ], $jsonBody);
    }

    public function testLoginSuccess()
    {
        $response = $this->runApp('POST', '/user/login', [
            'username' => 'admin',
            'password' => '123456789'
        ]);

        $jsonBody = $this->decodeResponse($response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(200, $jsonBody['code']);
        $this->assertEquals('Autenticado com sucesso', $jsonBody['message']);

        $decodedInfo = JWT::decode($jsonBody['data']['token'], $this->secret, ['HS256']);
        $this->assertSame(1, $decodedInfo->data->id);
    }


    public function testLoginWrongUser()
    {
        $response = $this->runApp('POST', '/user/login', [
            'username' => 'aaaaaaaa',
            'password' => '123456789'
        ]);
        $jsonBody = $this->decodeResponse($response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(400, $jsonBody['code']);
        $this->assertEquals('Usuário não encontrado', $jsonBody['message']);
        $this->assertEquals([], $jsonBody['data']);
    }

    public function testLoginEmptyUser()
    {
        $response = $this->runApp('POST', '/user/login', [
            'password' => '123456789',
        ]);
        $jsonBody = $this->decodeResponse($response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(400, $jsonBody['code']);
        $this->assertEquals('Informe o nome de usuário e a senha', $jsonBody['message']);
        $this->assertEquals([], $jsonBody['data']);
    }

    public function testLoginWrongPassword()
    {
        $response = $this->runApp('POST', '/user/login', [
            'username' => 'admin',
            'password' => '987654321'
        ]);
        $jsonBody = $this->decodeResponse($response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(400, $jsonBody['code']);
        $this->assertEquals('Usuário ou senha incorreta', $jsonBody['message']);
        $this->assertEquals([], $jsonBody['data']);
    }

    public function testLoginEmptyPassword()
    {
        $response = $this->runApp('POST', '/user/login', [
            'username' => 'aaaaaaaa',
        ]);
        $jsonBody = $this->decodeResponse($response);
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals(400, $jsonBody['code']);
        $this->assertEquals('Informe o nome de usuário e a senha', $jsonBody['message']);
        $this->assertEquals([], $jsonBody['data']);
    }

    public function tearDown()
    {
        // specific tearDown
        parent::tearDown();
    }
}
