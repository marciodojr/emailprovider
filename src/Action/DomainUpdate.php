<?php

namespace Mdojr\EmailProvider\Action;

use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Exception;

class DomainUpdate
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $vdomain;

    public function __construct(VirtualDomain $vdomain)
    {
        $this->vdomain = $vdomain;
    }

    public function __invoke($request, $response, $domainId)
    {
        $params = $request->getParams();

        try {
            if(empty($params['name'])) {
                throw new Exception('Domínio não informado');
            }
            $domain = $this->vdomain->update($domainId, $params['name']);
            return $this->toJson($response, 200, 'ok', $domain);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }
}
