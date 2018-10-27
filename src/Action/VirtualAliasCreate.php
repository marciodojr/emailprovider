<?php

namespace Mdojr\EmailProvider\Action;

use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Exception;

class VirtualAliasCreate
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $valias;

    public function __construct(VirtualAlias $valias)
    {
        $this->valias = $valias;
    }

    public function __invoke($request, $response)
    {
        $params = $request->getParams();

        try {
            if(empty($params['sourceId']) || empty($params['destination'])) {
                throw new Exception('Email de origem ou alias não informado');
            }
            $alias = $this->valias->create($params['sourceId'], $params['destination']);
            return $this->toJson($response, 200, 'ok', $alias);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }
}
