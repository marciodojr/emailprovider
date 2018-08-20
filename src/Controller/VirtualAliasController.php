<?php

namespace Mdojr\EmailProvider\Controller;

use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Exception;

class VirtualAliasController
{
    private $valias;

    public function __construct(VirtualAlias $valias)
    {
        $this->valias = $valias;
    }

    public function listAll($request, $response)
    {
        try {
            $valiasesData = $this->valias->fetchAll();
            return $response->json(200, 'ok', $valiasesData);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }

    public function create($request, $response)
    {
        $params = $request->getParams();

        try {
            $alias = $this->valias->create($params['sourceId'], $params['destination']);
            return $response->json(200, 'ok', $alias);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }

    public function delete($request, $response)
    {
        $params = $request->getParams();
        try {
            $this->valias->delete($params['aliases']);
            return $response->json();
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }
}
