<?php

namespace Mdojr\EmailProvider\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

use Mdojr\EmailProvider\Middleware\Auth;

$app->post('/user/login', LoginController::class . ':login');

// crud domínios
$app->group('/virtual-domains', function () {
    $this->get('', DomainController::class . ':listAll');
    $this->post('', DomainController::class . ':create');
    $this->patch('/{id:[0-9]+}', DomainController::class . ':update');
    $this->delete('', DomainController::class . ':delete');
});
// ->add(Auth::class);

// crud emails
$app->group('/virtual-users', function() {
    $this->get('', VirtualUserController::class . ':listAll');
    $this->post('', VirtualUserController::class . ':create');
    $this->delete('', VirtualUserController::class . ':delete');
});
// ->add(Auth::class);

// crud aliases
$app->group('/virtual-aliases', function(){
    $this->get('', VirtualAliasController::class . ':listAll');
    $this->post('', VirtualAliasController::class . ':create');
    $this->delete('', VirtualAliasController::class . ':delete');
});
// ->add(Auth::class);
