<?php

namespace Mdojr\EmailProvider\Test\Functional\Alias;

use Exception;

class VirtualAliasCreateFunc extends VirtualAlias
{
    public function testCreateAliasWithoutToken()
    {
        $response = $this->runApp('POST', '/virtual-aliases');
        $this->check403Response($response);
    }

    public function testCreateAliasesSuccess()
    {
        $response = $this->runApp('POST', '/virtual-aliases', [
            'sourceId' => $this->emailToAlias['id'],
            'destination' => $this->aliasToCreate
        ], $this->token);

        $this->assertEquals(200, $response->getStatusCode());

        $jsonBody = $this->decodeResponse($response);
        $this->assertEquals($this->emailToAlias['email'], $jsonBody['data']['source']);
        $this->assertEquals($this->aliasToCreate, $jsonBody['data']['destination']);

        $this->assertCount(3, $this->fetchAliases());
    }
}
