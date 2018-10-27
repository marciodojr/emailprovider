<?php

namespace Mdojr\EmailProvider\Test\Functional\Email;

use Exception;

class VirtualUsersCreateFunc extends VirtualUsers
{
    public function testCreateEmailWithoutToken()
    {
        $response = $this->runApp('POST', '/virtual-users');
        $this->check403Response($response);
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
}
