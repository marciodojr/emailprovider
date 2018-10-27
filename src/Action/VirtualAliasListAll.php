<?php

namespace Mdojr\EmailProvider\Action;

use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Exception;

class VirtualAliasListAll
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $valias;

    public function __construct(VirtualAlias $valias)
    {
        $this->valias = $valias;
    }

    public function __invoke($request, $response)
    {
        try {
            $valiasesData = $this->valias->fetchAll();
            return $this->toJson($response, 200, 'ok', $valiasesData);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }
}
