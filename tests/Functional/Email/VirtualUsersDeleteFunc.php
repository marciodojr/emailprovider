<?php

namespace Mdojr\EmailProvider\Test\Functional\Email;

use Exception;

class VirtualUsersDeleteFunc extends VirtualUsers
{
    public function testDeleteEmailWithoutToken()
    {
        $response = $this->runApp('DELETE', '/virtual-users');
        $this->check403Response($response);
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
}
