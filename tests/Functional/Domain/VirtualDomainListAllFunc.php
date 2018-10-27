<?php

namespace Mdojr\EmailProvider\Test\Functional\Domain;

use Exception;

class VirtualDomainListAllFunc extends VirtualDomain
{
    public function testListDomainWithoutToken()
    {
        $response = $this->runApp('GET', '/virtual-domains');
        $this->check403Response($response);
    }

    public function testListDomain()
    {
        $response = $this->runApp('GET', '/virtual-domains', null, $this->token);
        $body = $this->decodeResponse($response);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(200, $body['code']);
        $this->assertSame('ok', $body['message']);
        $this->assertEquals($this->domains, $body['data']);
    }
}
