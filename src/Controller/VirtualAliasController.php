<?php

namespace Mdojr\EmailProvider\Controller;

use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Mdojr\EmailProvider\Model\ResponseHandler;
use Exception;

class VirtualAliasController
{
    private $valias;

    public function __construct(VirtualAlias $valias)
    {
        $this->valias = $valias;
    }

    public function listAll()
    {
        try {
            $valiasesData = $this->valias->fetchAll();
            $rp = new ResponseHandler(200, 'ok', $valiasesData);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }

    public function create($request)
    {
        $params = $request->getPostParams();

        try {
            $alias = $this->valias->create($params['sourceId'], $params['destination']);
            $rp = new ResponseHandler(200, 'ok', $alias);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }

    public function delete($request)
    {
        $params = $request->getPostParams();
        try {
            $this->valias->delete($params['id']);
            $rp = new ResponseHandler(200);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }
}
