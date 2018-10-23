<?php

namespace Mdojr\EmailProvider\Test\Functional\Alias;

use Mdojr\EmailProvider\Test\Functional\TestCase;
use Exception;

class VirtualAliasFunctionalTest extends TestCase
{
    private $domain = [
        'id' => 10,
        'name' => 'domain.com'
    ];

    private $emailToAlias = [
        'id' => 1,
        'domain_id' => 10,
        'password' => 'some_hash',
        'email' => 'bb@domain.com'
    ];

    private $aliases = [
        [
            'id' => 1,
            'domain_id' => 10,
            'source' => 'bb@domain.com',
            'destination' => 'destination1@aliases.com'
        ],
        [
            'id' => 2,
            'domain_id' => 10,
            'source' => 'bb@domain.com',
            'destination' => 'destination2@aliases.com'
        ]
    ];

    private $aliasToCreate = 'destination3@aliases.com';

    public function setUp()
    {
        parent::setUp();
        $this->conn->insert('virtual_domains', $this->domain);
        $this->conn->insert('virtual_aliases', $this->aliases[0]);
        $this->conn->insert('virtual_aliases', $this->aliases[1]);
        $this->conn->insert('virtual_users', $this->emailToAlias);
    }

    public function testListAliasWithoutToken()
    {
        $response = $this->runApp('GET', '/virtual-aliases');
        $this->check403Response($response);
    }

    public function testCreateAliasWithoutToken()
    {
        $response = $this->runApp('POST', '/virtual-aliases');
        $this->check403Response($response);
    }

    public function testDeleteAliasWithoutToken()
    {
        $response = $this->runApp('DELETE', '/virtual-aliases');
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

    public function fetchAliases()
    {
        $stmt = $this->conn->executeQuery('select * from virtual_aliases');
        return $stmt->fetchAll();
    }

    public function tearDown()
    {
        $this->conn->delete('virtual_aliases', [
            'id' => $this->aliases[0]['id']
        ]);
        $this->conn->delete('virtual_aliases', [
            'id' => $this->aliases[1]['id']
        ]);
        $this->conn->delete('virtual_aliases', [
            'destination' => $this->aliasToCreate
        ]);
        $this->conn->delete('virtual_users', [
            'id' => $this->emailToAlias['id']
        ]);
        $this->conn->delete('virtual_domains', [
            'id' => $this->domain['id']
        ]);
        parent::tearDown();
    }
}
