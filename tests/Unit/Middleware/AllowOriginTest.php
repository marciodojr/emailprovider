<?php

namespace Mdojr\EmailProvider\Test\Unit\Middleware;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\Middleware\AllowOrigin;
use Slim\Http\Request;
use Slim\Http\Response;

class AllowOriginTest extends TestCase
{
    use \Mdojr\EmailProvider\Test\Unit\ResponseTestCase;

    public function testCorsHeaders()
    {
        $fakeReq = $this->createMock(Request::class);
        $aOrigin = new AllowOrigin();
        $response = $aOrigin->process($fakeReq, new Response, function($req, $resp) {
            return $resp;
        });
        $this->assertSame(
            $response->getHeaderLine('Access-Control-Allow-Origin'),
            '*'
        );
        $this->assertSame(
            $response->getHeaderLine('Access-Control-Allow-Headers'),
            'X-Requested-With, Content-Type, Accept, Origin, Authorization'
        );
        $this->assertSame(
            $response->getHeaderLine('Access-Control-Allow-Methods'),
            'GET, POST, PUT, DELETE, PATCH, OPTIONS'
        );
    }
}
