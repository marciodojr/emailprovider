<?php

namespace Mdojr\EmailProvider\Action;

use Mdojr\EmailProvider\Service\Database\VirtualDomain;
use Exception;

class DomainDelete
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $vdomain;

    public function __construct(VirtualDomain $vdomain)
    {
        $this->vdomain = $vdomain;
    }

    public function __invoke($request, $response)
    {
        $params = $request->getParams();
        try {
            if(empty($params['domains'])) {
                throw new Exception('Nenhum domínio foi informado');
            }
            $this->vdomain->delete($params['domains']);
            return $this->toJson($response, 204);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }
}
