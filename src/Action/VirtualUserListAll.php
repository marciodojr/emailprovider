<?php

namespace Mdojr\EmailProvider\Action;

use Mdojr\EmailProvider\Service\Database\VirtualUser;
use Exception;

class VirtualUserListAll
{
    use \Mdojr\EmailProvider\Helper\JsonResponse;

    private $vuser;

    public function __construct(VirtualUser $vuser)
    {
        $this->vuser = $vuser;
    }

    public function __invoke($request, $response)
    {
        try {
            $vusersData = $this->vuser->fetchAll();
            return $this->toJson($response, 200, 'ok', $vusersData);
        } catch(Exception $ex) {
            return $this->toJson($response, 400, $ex->getMessage());
        }
    }
}
