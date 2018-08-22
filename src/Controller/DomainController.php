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

    public function update($request, $response, $urlParams)
    {
        $params = $request->getParams();

        try {
            $domain = $this->vdomain->update($urlParams[0], $params['name']);
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
            $this->vdomain->delete($params['domains']);
            return $response->json(200);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }
}
