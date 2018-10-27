<?php

namespace Mdojr\EmailProvider\Test\Functional\Alias;

use Exception;

class VirtualAliasDeleteFunc extends VirtualAlias
{
    public function testDeleteAliasWithoutToken()
    {
        $response = $this->runApp('DELETE', '/virtual-aliases');
        $this->check403Response($response);
    }

    public function testDeleteAliasesSuccess()
    {
        $response = $this->runApp('DELETE', '/virtual-aliases', [
            'aliases' => [
                $this->aliases[0]['id']
            ]
        ], $this->token);

        $this->assertEquals(204, $response->getStatusCode());
        $res = $this->fetchAliases();
        $this->assertCount(1, $res);
        $this->assertEquals($this->aliases[1]['id'], $res[0]['id']);
    }
}
