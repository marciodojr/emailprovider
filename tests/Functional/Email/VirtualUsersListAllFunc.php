<?php

namespace Mdojr\EmailProvider\Test\Functional\Email;

use Exception;

class VirtualUsersListAllFunc extends VirtualUsers
{
    public function testListEmailWithoutToken()
    {
        $response = $this->runApp('GET', '/virtual-users');
        $this->check403Response($response);
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
}
