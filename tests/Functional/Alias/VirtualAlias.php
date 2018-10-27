<?php

namespace Mdojr\EmailProvider\Test\Functional\Alias;

use Mdojr\EmailProvider\Test\Functional\TestCase;
use Exception;

class VirtualAlias extends TestCase
{
    protected $domain = [
        'id' => 10,
        'name' => 'domain.com'
    ];

    protected $emailToAlias = [
        'id' => 1,
        'domain_id' => 10,
        'password' => 'some_hash',
        'email' => 'bb@domain.com'
    ];

    protected $aliases = [
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

    protected $aliasToCreate = 'destination3@aliases.com';

    public function setUp()
    {
        parent::setUp();
        $this->conn->insert('virtual_domains', $this->domain);
        $this->conn->insert('virtual_aliases', $this->aliases[0]);
        $this->conn->insert('virtual_aliases', $this->aliases[1]);
        $this->conn->insert('virtual_users', $this->emailToAlias);
    }

    protected function fetchAliases()
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
