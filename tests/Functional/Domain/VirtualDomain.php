<?php

namespace Mdojr\EmailProvider\Test\Functional\Domain;

use Mdojr\EmailProvider\Test\Functional\TestCase;
use Exception;

class VirtualDomain extends TestCase
{
    protected $domains = [
        [
            'id' => 1,
            'name' => 'otherdomain'
        ],
        [
            'id' => 2,
            'name' => 'somedomain'
        ],
    ];

    protected $domainToCreate = 'magicdomain.com';
    protected $domainToEdit = 'otherdomain_edited';

    public function setUp()
    {
        parent::setUp();
        $this->conn->insert('virtual_domains', $this->domains[0]);
        $this->conn->insert('virtual_domains', $this->domains[1]);
    }

    protected function fetchDomains()
    {
        $stmt = $this->conn->executeQuery('select * from virtual_domains');
        return $stmt->fetchAll();
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
