<?php

namespace Mdojr\EmailProvider\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

use Mdojr\EmailProvider\Middleware\Auth;
use Mdojr\EmailProvider\Middleware\AllowOrigin;

// enable CORS
$app->options('/{routes:.+}', function ($request, $response) {
    return $response;
});
$app->add(AllowOrigin::class . ':process');


$app->post('/user/login', LoginController::class . ':login');

$app->group('', function(){
    // crud domínios
    $this->group('/virtual-domains', function () {
        $this->get('', DomainController::class . ':listAll');
        $this->post('', DomainController::class . ':create');
        $this->patch('/{id:[0-9]+}', DomainController::class . ':update');
        $this->delete('', DomainController::class . ':delete');
    });
    // crud emails
    $this->group('/virtual-users', function() {
        $this->get('', VirtualUserController::class . ':listAll');
        $this->post('', VirtualUserController::class . ':create');
        $this->delete('', VirtualUserController::class . ':delete');
    });
    // crud aliases
    $this->group('/virtual-aliases', function(){
        $this->get('', VirtualAliasController::class . ':listAll');
        $this->post('', VirtualAliasController::class . ':create');
        $this->delete('', VirtualAliasController::class . ':delete');
    });
})->add(Auth::class . ':process');
