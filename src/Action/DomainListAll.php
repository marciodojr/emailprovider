<?php

namespace Mdojr\EmailProvider\Action;

use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Exception;

class DomainListAll
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $vdomain;

    public function __construct(VirtualDomain $vdomain)
    {
        $this->vdomain = $vdomain;
    }

    public function __invoke($request, $response)
    {
        try {
            $vdomainData = $this->vdomain->fetchAll();
            return $this->toJson($response, 200, 'ok', $vdomainData);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }
}
