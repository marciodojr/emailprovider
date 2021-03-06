<?php

namespace Mdojr\EmailProvider\Test\Unit\Handler;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Handler\NotFound;
use Slim\Http\Request;
use Slim\Http\Response;

class NotFoundTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testInvoke()
    {
        $response = new Response();
        $expectedJsonResponse = $this->toJson($response, 404, 'Recurso não encontrado');
        $handler = new NotFound();
        $request = $this->createMock(Request::class);
        $jsonResponse = $handler($request, $response);

        $this->checkResponseAssertions($jsonResponse, $expectedJsonResponse);
    }
}
