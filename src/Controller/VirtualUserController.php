<?php

namespace Mdojr\EmailProvider\Controller;

use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Exception;

class VirtualUserController
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $vuser;

    public function __construct(VirtualUser $vuser)
    {
        $this->vuser = $vuser;
    }

    public function listAll($request, $response)
    {
        try {
            $vusersData = $this->vuser->fetchAll();
            return $this->toJson($response, 200, 'ok', $vusersData);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }

    public function create($request, $response)
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

    public function delete($request, $response)
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
