<?php

namespace Mdojr\EmailProvider\Controller;

use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Exception;

class DomainController
{
    use Helper\JsonResponse;

    private $vdomain;

    public function __construct(VirtualDomain $vdomain)
    {
        $this->vdomain = $vdomain;
    }

    public function listAll($request, $response)
    {
        try {
            $vdomainData = $this->vdomain->fetchAll();
            $this->toJson($response, 200, 'ok', $vdomainData);
        } catch(Exception $ex) {
            $this->toJson($response, 400, $ex->getMessage());
        }
    }

    public function create($request, $response)
    {
        $params = $request->getParams();

        try {
            $domain = $this->vdomain->create($params['name']);
            $this->toJson($response, 200, 'ok', $domain);
        } catch(Exception $ex) {
            $this->toJson($response, 400, $ex->getMessage());
        }
    }

    public function update($request, $response, $urlParams)
    {
        $params = $request->getParams();

        try {
            $domain = $this->vdomain->update($urlParams[0], $params['name']);
            $this->toJson($response, 200, 'ok', $domain);
        } catch(Exception $ex) {
            $this->toJson($response, 400, $ex->getMessage());
        }

        $rp->printJson();
    }

    public function delete($request, $response)
    {
        $params = $request->getParams();
        try {
            $this->vdomain->delete($params['domains']);
            $this->toJson($response);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }
}
