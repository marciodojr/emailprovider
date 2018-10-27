<?php

namespace Mdojr\EmailProvider\Test\Unit;

use PHPUnit\Framework\TestCase;
use Mdojr\EmailProvider\App;
use DI\Bridge\Slim\App as PhpDiBridgeSlimApp;



class AppTest extends TestCase
{
    public function testIsInstanceOfPhpDiSlimBridge()
    {
        $containerDefinition = [];
        $app = new App($containerDefinition);
        $this->assertInstanceOf(PhpDiBridgeSlimApp::class, $app);
    }
}
