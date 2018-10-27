<?php

namespace Mdojr\EmailProvider\Test\Functional\Domain;

use Exception;

class VirtualDomainUpdateFunc extends VirtualDomain
{
    public function testEditDomainWithoutToken()
    {
        $response = $this->runApp('PATCH', '/virtual-domains/1');
        $this->check403Response($response);
    }

    public function testEditDomain()
    {
        $id = $this->domains[0]['id'];

        $response = $this->runApp('PATCH', sprintf('/virtual-domains/%s', $id), [
            'name' => $this->domainToEdit
        ], $this->token);
        $body = $this->decodeResponse($response);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(200, $body['code']);
        $this->assertSame('ok', $body['message']);

        $this->assertEquals([
            'id' => $id,
            'name' => $this->domainToEdit
        ], $body['data']);
        $this->assertEquals($this->fetchDomains()[0], $body['data']);
        $this->assertNotEquals($this->fetchDomains()[1]['name'], $body['data']['name']);
    }
}
