<?php

namespace Mdojr\EmailProvider\Controller;

use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Mdojr\EmailProvider\Model\ResponseHandler;
use Exception;

class DomainController
{
    private $vdomain;

    public function __construct(VirtualDomain $vdomain)
    {
        $this->vdomain = $vdomain;
    }

    public function listAll()
    {
        try {
            $vdomainData = $this->vdomain->fetchAll();
            $rp = new ResponseHandler(200, 'ok', $vdomainData);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }

    public function create($request)
    {
        $params = $request->getPostParams();

        try {
            $domain = $this->vdomain->create($params['name']);
            $rp = new ResponseHandler(200, 'ok', $domain);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }

    public function update($request)
    {
        $params = $request->getPostParams();

        try {
            $domain = $this->vdomain->update($params['id'], $params['name']);
            $rp = new ResponseHandler(200, 'ok', $domain);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }

    public function delete($request)
    {
        $params = $request->getPostParams();
        try {
            $this->vdomain->delete($params['id']);
            $rp = new ResponseHandler(200);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }
}
