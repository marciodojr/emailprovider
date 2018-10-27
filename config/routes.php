<?php

use Mdojr\EmailProvider\Middleware\Auth;
use Mdojr\EmailProvider\Middleware\AllowOrigin;

use Mdojr\EmailProvider\Action\Login;
use Mdojr\EmailProvider\Action\DomainListAll;
use Mdojr\EmailProvider\Action\DomainCreate;
use Mdojr\EmailProvider\Action\DomainUpdate;
use Mdojr\EmailProvider\Action\DomainDelete;
use Mdojr\EmailProvider\Action\VirtualUserListAll;
use Mdojr\EmailProvider\Action\VirtualUserCreate;
use Mdojr\EmailProvider\Action\VirtualUserDelete;
use Mdojr\EmailProvider\Action\VirtualAliasListAll;
use Mdojr\EmailProvider\Action\VirtualAliasCreate;
use Mdojr\EmailProvider\Action\VirtualAliasDelete;
use Mdojr\EmailProvider\Handler\NotFound;

$app->group('', function () {
    $this->post('/user/login', Login::class);
    $this->get('/', function ($response) {
        return $response;
    });
    $this->group('', function(){
        // crud domínios
        $this->group('/virtual-domains', function () {
            $this->get('', DomainListAll::class);
            $this->post('', DomainCreate::class);
            $this->patch('/{domainId:[0-9]+}', DomainUpdate::class);
            $this->delete('', DomainDelete::class);
        });
        // crud emails
        $this->group('/virtual-users', function () {
            $this->get('', VirtualUserListAll::class);
            $this->post('', VirtualUserCreate::class);
            $this->delete('', VirtualUserDelete::class);
        });
        // crud aliases
        $this->group('/virtual-aliases', function () {
            $this->get('', VirtualAliasListAll::class);
            $this->post('', VirtualAliasCreate::class);
            $this->delete('', VirtualAliasDelete::class);
        });
    })->add(Auth::class);
});

// enable CORS
$app->options('/{routes:.+}', function ($request, $response) {
    return $response;
});

$app->add(AllowOrigin::class);

// Catch-all route to serve a 404 Not Found page if none of the routes match
// NOTE: make sure this route is defined last
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', NotFound::class);
