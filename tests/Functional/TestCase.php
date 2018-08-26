<?php

namespace Mdojr\EmailProvider\Test\Functional;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;

class TestCase extends BaseTestCase
{
    protected $app;
    protected $conn;

    public function setUp()
    {
        $this->app = $GLOBALS['app'];
        $this->conn = $this->app->getContainer()->get(EntityManager::class)->getConnection();
    }

    protected function runApp($requestMethod, $requestUri, $requestData = null, $token = null)
    {
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );
        $request = Request::createFromEnvironment($environment);
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        if($token) {
            $request = $request->withHeader('Authorization', sprintf('Bearer %s', $token));
        }

        return $this->app->process($request, new Response());
    }

    public function tearDown()
    {
        $this->app = null;
    }

    protected function decodeResponse(Response $response, $asArray = true)
    {
        return json_decode($response->getBody(), $asArray);
    }

    protected function check403Response(Response $response)
    {
        $body = $this->decodeResponse($response);

        $this->assertSame(403, $response->getStatusCode());
        $this->assertSame(403, $body['code']);
        $this->assertSame('Você não possui permissão para acessar este recurso', $body['message']);
        $this->assertSame([], $body['data']);
    }
}
