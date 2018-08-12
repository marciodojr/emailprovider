<?php

namespace Mdojr\EmailProvider\Controller;

use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Exception;

class VirtualUserController
{
    private $vuser;

    public function __construct(VirtualUser $vuser)
    {
        $this->vuser = $vuser;
    }

    public function listAll($request, $response)
    {
        try {
            $vusersData = $this->vuser->fetchAll();
            return $response->json(200, 'ok', $vusersData);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }

    public function create($request, $response)
    {
        $params = $request->getParams();

        try {
            $vusersData = $this->vuser->create($params['email'], $params['password'], $params['domain']);
            return $response->json(200, 'ok', $vusersData);
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }

    public function delete($request, $response)
    {
        $params = $request->getParams();
        try {
            $this->vuser->delete($params['id']);
            return $response->json();
        } catch(Exception $ex) {
            return $response->json(400, $ex->getMessage());
        }
    }
}
