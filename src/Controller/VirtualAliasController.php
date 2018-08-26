<?php

namespace Mdojr\EmailProvider\Controller;

use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Exception;

class VirtualAliasController
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $valias;

    public function __construct(VirtualAlias $valias)
    {
        $this->valias = $valias;
    }

    public function listAll($request, $response)
    {
        try {
            $valiasesData = $this->valias->fetchAll();
            return $this->toJson($response, 200, 'ok', $valiasesData);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }

    public function create($request, $response)
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

    public function delete($request, $response)
    {
        $params = $request->getParams();
        try {
            if(empty($params['aliases'])) {
                throw new Exception('Nenhum alias foi informado');
            }
            $this->valias->delete($params['aliases']);
            return $this->toJson($response, 204);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }
}
