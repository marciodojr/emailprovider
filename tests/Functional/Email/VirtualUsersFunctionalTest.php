<?php

namespace Mdojr\EmailProvider\Test\Functional\Email;

use Mdojr\EmailProvider\Test\Functional\TestCase;
use Exception;

class VirtualUsersFunctionalTest extends TestCase
{
    private $domain = [
        'id' => 456,
        'name' => 'domain.com'
    ];

    private $emails = [
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

    private $emailToCreate = 'somemagicemail';

    public function setUp()
    {
        parent::setUp();

        $this->conn->insert('virtual_domains', $this->domain);
        $this->conn->insert('virtual_users', $this->emails[0]);
        $this->conn->insert('virtual_users', $this->emails[1]);
    }

    public function testListEmailSuccess()
    {
        $response = $this->runApp('GET', '/virtual-users', null, $this->token);

        $this->assertEquals(200, $response->getStatusCode());

        $jsonBody = $this->decodeResponse($response);
        $this->assertCount(2, $jsonBody['data']);
        $this->assertEquals($this->emails[0]['id'], $jsonBody['data'][0]['id']);
        $this->assertEquals($this->emails[1]['id'], $jsonBody['data'][1]['id']);
    }

    public function testCreateEmailSuccess()
    {
        $response = $this->runApp('POST', '/virtual-users', [
            'email' => $this->emailToCreate,
            'domain' => $this->domain['id'],
            'password' => 'some_password'
        ], $this->token);

        $jsonBody = $this->decodeResponse($response);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(3, $this->fetchEmails());
        $this->assertEquals($this->emailToCreate .'@'. $this->domain['name'], $jsonBody['data']['email']);
    }

    public function testDeleteEmailSuccess()
    {
        $response = $this->runApp('DELETE', '/virtual-users', [
            'emails' => [
                $this->emails[0]['id']
            ]
        ], $this->token);

        $this->assertEquals(204, $response->getStatusCode());
        $emails = $this->fetchEmails();
        $this->assertCount(1, $emails);
        $this->assertEquals($this->emails[1]['id'], $emails[0]['id']);
    }

    public function testListEmailWithoutToken()
    {
        $response = $this->runApp('GET', '/virtual-users');
        $this->check403Response($response);
    }

    public function testCreateEmailWithoutToken()
    {
        $response = $this->runApp('POST', '/virtual-users');
        $this->check403Response($response);
    }

    public function testDeleteEmailWithoutToken()
    {
        $response = $this->runApp('DELETE', '/virtual-users');
        $this->check403Response($response);
    }

    private function fetchEmails()
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
