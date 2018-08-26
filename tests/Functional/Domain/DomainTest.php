<?php

namespace Mdojr\EmailProvider\Test\Functional\Domain;

use Mdojr\EmailProvider\Test\Functional\TestCase;
use Exception;

class DomainTest extends TestCase
{
    private $token;
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

    public function setUp()
    {
        parent::setUp();

        $response = $this->runApp('POST', '/user/login', [
            'username' => 'admin',
            'password' => '123456789'
        ]);

        $this->token = $this->decodeResponse($response)['data']['token'];
        $this->conn->executeQuery('DELETE FROM virtual_domains; ALTER TABLE virtual_domains AUTO_INCREMENT = 1;');
    }

    public function testCreateDomain()
    {
        $response = $this->createDomain($this->domains[0]['name']);
        $body = $this->decodeResponse($response);

        // response
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(200, $body['code']);
        $this->assertSame('ok', $body['message']);

        // response data
        $this->assertSame($body['data']['name'], $this->domains[0]['name']);
        $this->assertSame($this->domains[0]['id'], $body['data']['id']);

        // db check
        $response = $this->createDomain($this->domains[1]['name']);
        $this->assertSame(2, count($this->fetchDomains()));
    }

    private function createDomain($name)
    {
        return $this->runApp('POST', '/virtual-domains', [
            'name' => $name
        ], $this->token);
    }

    private function fetchDomains()
    {
        $stmt = $this->conn->executeQuery('select * from virtual_domains');
        return $stmt->fetchAll();
    }

    public function testListDomain()
    {
        $this->createDomain($this->domains[0]['name']);
        $this->createDomain($this->domains[1]['name']);

        $response = $this->runApp('GET', '/virtual-domains', null, $this->token);
        $body = $this->decodeResponse($response);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(200, $body['code']);
        $this->assertSame('ok', $body['message']);
        $this->assertEquals($this->domains, $body['data']);
        $this->assertEquals($this->fetchDomains(), $body['data']);
    }

    public function testEditDomain()
    {
        $id = $this->domains[0]['id'];
        $newName = 'otherdomain_edited';
        $this->createDomain($this->domains[0]['name']);
        $this->createDomain($this->domains[1]['name']);

        $response = $this->runApp('PATCH', sprintf('/virtual-domains/%s', $id), [
            'name' => $newName
        ], $this->token);
        $body = $this->decodeResponse($response);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(200, $body['code']);
        $this->assertSame('ok', $body['message']);

        $this->assertEquals([
            'id' => $id,
            'name' => $newName
        ], $body['data']);
        $this->assertEquals($this->fetchDomains()[0], $body['data']);
        $this->assertNotEquals($this->fetchDomains()[1]['name'], $body['data']['name']);
    }

    public function testDeleteDomain()
    {
        $id1 = $this->domains[0]['id'];
        $id2 = $this->domains[1]['id'];
        $this->createDomain($this->domains[0]['name']);
        $this->createDomain($this->domains[1]['name']);

        $response = $this->runApp('DELETE', '/virtual-domains', [
            'domains' => [$id1, $id2]
        ], $this->token);
        $body = $this->decodeResponse($response);

        $this->assertSame(204, $response->getStatusCode());
        $this->assertEquals(count($this->fetchDomains()), 0);
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
}
