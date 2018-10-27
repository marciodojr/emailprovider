<?php

namespace Mdojr\EmailProvider\Action;

use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Exception;

class VirtualUserDelete
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $vuser;

    public function __construct(VirtualUser $vuser)
    {
        $this->vuser = $vuser;
    }

    public function __invoke($request, $response)
    {
        $params = $request->getParams();
        try {
            if(empty($params['emails'])) {
                throw new Exception('Nenhum email foi informado');
            }
            $this->vuser->delete($params['emails']);
            return $this->toJson($response, 204);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }
}
