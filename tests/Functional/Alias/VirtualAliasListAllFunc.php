<?php

namespace Mdojr\EmailProvider\Test\Functional\Alias;

use Exception;

class VirtualAliasListAllFunc extends VirtualAlias
{
    public function testListAliasWithoutToken()
    {
        $response = $this->runApp('GET', '/virtual-aliases');
        $this->check403Response($response);
    }

    public function testListAliasesSuccess()
    {
        $response = $this->runApp('GET', '/virtual-aliases', null, $this->token);

        $this->assertEquals(200, $response->getStatusCode());

        $jsonBody = $this->decodeResponse($response);
        $this->assertCount(2, $jsonBody['data']);
        $this->assertEquals($this->aliases[0]['id'], $jsonBody['data'][0]['id']);
        $this->assertEquals($this->aliases[1]['id'], $jsonBody['data'][1]['id']);
    }
}
