<?php

namespace Mdojr\Emailprovider\Middleware\Helper;

trait AcceptJson
{
    private $jsonHeader = 'application/json';

    private function acceptJson($headerLine)
    {
        return false !== strpos($headerLine, $this->jsonHeader);
    }
}
