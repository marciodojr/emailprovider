<?php

namespace Mdojr\EmailProvider\Test\Functional\Domain;

use Exception;

class VirtualDomainCreateFunc extends VirtualDomain
{
    public function testListDomainWithoutToken()
    {
        $response = $this->runApp('GET', '/virtual-domains');
        $this->check403Response($response);
    }

    public function testCreateDomain()
    {
        $response = $this->runApp('POST', '/virtual-domains', [
            'name' => $this->domainToCreate
        ], $this->token);
        $body = $this->decodeResponse($response);

        // response
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(200, $body['code']);
        $this->assertSame('ok', $body['message']);

        // response data
        $this->assertSame($body['data']['name'], $this->domainToCreate);

        // db
        $this->assertCount(3, $this->fetchDomains());
    }
}
