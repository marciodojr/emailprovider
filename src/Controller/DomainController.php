<?php

namespace Mdojr\EmailProvider\Controller;

use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Exception;

class DomainController
{
    private $vdomain;

    public function __construct(VirtualDomain $vdomain)
    {
        $this->vdomain = $vdomain;
    }

    public function listAll($request, $response)
    {
        try {
            $vdomainData = $this->vdomain->fetchAll();
            return $response->json(200, 'ok', $vdomainData);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }

    public function create($request, $response)
    {
        $params = $request->getParams();

        try {
            $domain = $this->vdomain->create($params['name']);
            return $response->json(200, 'ok', $domain);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }

    public function update($request, $response)
    {
        $params = $request->getParams();

        try {
            $domain = $this->vdomain->update($params['id'], $params['name']);
            return $response->json(200, 'ok', $domain);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }

        $rp->printJson();
    }

    public function delete($request, $response)
    {
        $params = $request->getParams();
        try {
            $this->vdomain->delete($params['id']);
            return $response->json(200);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }
}
