<?php

namespace Mdojr\EmailProvider\Test\Functional\Domain;

use Mdojr\EmailProvider\Test\Functional\TestCase;
use Exception;

class VirtualDomainFunctionalTest extends TestCase
{
    private $domains = [
        [
            'id' => 1,
            'name' => 'otherdomain'
        ],
        [
            'id' => 2,
            'name' => 'somedomain'
        ],
    ];

    private $domainToCreate = 'magicdomain.com';
    private $domainToEdit = 'otherdomain_edited';

    public function setUp()
    {
        parent::setUp();
        $this->conn->insert('virtual_domains', $this->domains[0]);
        $this->conn->insert('virtual_domains', $this->domains[1]);
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

    private function fetchDomains()
    {
        $stmt = $this->conn->executeQuery('select * from virtual_domains');
        return $stmt->fetchAll();
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

    public function testDeleteDomain()
    {
        $response = $this->runApp('DELETE', '/virtual-domains', [
            'domains' => [$this->domains[0]['id']]
        ], $this->token);
        $body = $this->decodeResponse($response);

        $this->assertSame(204, $response->getStatusCode());
        $this->assertCount(1, $this->fetchDomains());
    }

    public function testListDomainWithoutToken()
    {
        $response = $this->runApp('GET', '/virtual-domains');
        $this->check403Response($response);
    }

    public function testCreateDomainWithoutToken()
    {
        $response = $this->runApp('POST', '/virtual-domains');
        $this->check403Response($response);
    }

    public function testEditDomainWithoutToken()
    {
        $response = $this->runApp('PATCH', '/virtual-domains/1');
        $this->check403Response($response);
    }

    public function testDeleteDomainWithoutToken()
    {
        $response = $this->runApp('DELETE', '/virtual-domains');
        $this->check403Response($response);
    }

    public function tearDown()
    {
        $this->conn->delete('virtual_domains', [
            'id' => $this->domains[0]['id']
        ]);
        $this->conn->delete('virtual_domains', [
            'id' => $this->domains[1]['id']
        ]);
        $this->conn->delete('virtual_domains', [
            'name' => $this->domainToCreate
        ]);
        parent::tearDown();
    }
}
