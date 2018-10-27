<?php

namespace Mdojr\EmailProvider\Action;

use Mdojr\EmailProvider\Service\Database\VirtualAlias;
use Exception;

class VirtualAliasDelete
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
