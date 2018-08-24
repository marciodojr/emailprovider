<?php

namespace Mdojr\EmailProvider\Handler;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFound
{
    use \Mdojr\EmailProvider\Controller\Helper\JsonResponse;

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this->toJson($response, 404, 'Recurso não encontrado');
    }
}
