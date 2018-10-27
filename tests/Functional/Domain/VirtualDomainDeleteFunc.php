<?php

namespace Mdojr\EmailProvider\Test\Functional\Domain;

use Exception;

class VirtualDomainDeleteFunc extends VirtualDomain
{
    public function testDeleteDomainWithoutToken()
    {
        $response = $this->runApp('DELETE', '/virtual-domains');
        $this->check403Response($response);
    }

    public function testDeleteDomain()
    {
        $response = $this->runApp('DELETE', '/virtual-domains', [
            'domains' => [$this->domains[0]['id']]
        ], $this->token);
        $body = $this->decodeResponse($response);

        $this->assertSame(204, $response->getStatusCode());
        $this->assertCount(1, $this->fetchDomains());
    }
}
