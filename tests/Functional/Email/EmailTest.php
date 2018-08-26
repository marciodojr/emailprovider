<?php

namespace Mdojr\EmailProvider\Test\Functional\Email;

use Mdojr\EmailProvider\Test\Functional\TestCase;
use Exception;

class EmailTest extends TestCase
{
    private $token;

    public function setUp()
    {
        parent::setUp();

        $response = $this->runApp('POST', '/user/login', [
            'username' => 'admin',
            'password' => '123456789'
        ]);

        $this->token = $this->decodeResponse($response)['data']['token'];
        $this->conn->executeQuery('DELETE FROM virtual_users; ALTER TABLE virtual_users AUTO_INCREMENT = 1;');
    }

    public function testListWithoutToken()
    {
        $response = $this->runApp('GET', '/virtual-users');
        $this->check403Response($response);
    }

    public function testCreateWithoutToken()
    {
        $response = $this->runApp('POST', '/virtual-users');
        $this->check403Response($response);
    }

    public function testDeleteWithoutToken()
    {
        $response = $this->runApp('DELETE', '/virtual-users');
        $this->check403Response($response);
    }
}
