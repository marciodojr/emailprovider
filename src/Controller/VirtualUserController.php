<?php

namespace Mdojr\EmailProvider\Controller;

use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Mdojr\EmailProvider\Model\ResponseHandler;
use Exception;

class VirtualUserController
{
    private $vuser;

    public function __construct(VirtualUser $vuser)
    {
        $this->vuser = $vuser;
    }

    public function listAll()
    {
        try {
            $vusersData = $this->vuser->fetchAll();
            $rp = new ResponseHandler(200, 'ok', $vusersData);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }

    public function create($request)
    {
        $params = $request->getPostParams();

        try {
            $vusersData = $this->vuser->create($params['email'], $params['password'], $params['domain']);
            $rp = new ResponseHandler(200, 'ok', $vusersData);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }

    public function delete($request)
    {
        $params = $request->getPostParams();
        try {
            $this->vuser->delete($params['id']);
            $rp = new ResponseHandler(200);
        } catch(Exception $ex) {
            $rp = new ResponseHandler(400, $ex->getMessage());
        }

        $rp->printJson();
    }
}
