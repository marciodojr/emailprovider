<?php

namespace Mdojr\EmailProvider\Action;

use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Exception;

class VirtualUserCreate
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
            if(empty($params['email']) || empty($params['password']) || empty($params['domain'])) {
                throw new Exception('Informe o email, a senha e o domínio');
            }
            $vusersData = $this->vuser->create($params['email'], $params['password'], $params['domain']);
            return $this->toJson($response, 200, 'ok', $vusersData);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }
}
