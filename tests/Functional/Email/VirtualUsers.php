<?php

namespace Mdojr\EmailProvider\Test\Functional\Email;

use Mdojr\EmailProvider\Test\Functional\TestCase;
use Exception;

class VirtualUsers extends TestCase
{
    protected $domain = [
        'id' => 456,
        'name' => 'domain.com'
    ];

    protected $emails = [
        [
            'id' => 1000,
            'domain_id' => 456,
            'password' => 'some_hash',
            'email' => 'bb1@domain.com'
        ],
        [
            'id' => 1001,
            'domain_id' => 456,
            'password' => 'some_other_hash',
            'email' => 'bb2@domain.com'
        ],
    ];

    protected $emailToCreate = 'somemagicemail';

    public function setUp()
    {
        parent::setUp();

        $this->conn->insert('virtual_domains', $this->domain);
        $this->conn->insert('virtual_users', $this->emails[0]);
        $this->conn->insert('virtual_users', $this->emails[1]);
    }

    protected function fetchEmails()
    {
        $stmt = $this->conn->executeQuery('select * from virtual_users');
        return $stmt->fetchAll();
    }

    public function tearDown()
    {
        $this->conn->delete('virtual_users', [
            'id' => $this->emails[0]['id']
        ]);
        $this->conn->delete('virtual_users', [
            'id' => $this->emails[1]['id']
        ]);
        $this->conn->delete('virtual_users', [
            'email' => $this->emailToCreate . '@' . $this->domain['name']
        ]);
        $this->conn->delete('virtual_domains', [
            'id' => $this->domain['id']
        ]);
        parent::tearDown();
    }
}
