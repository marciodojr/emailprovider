<?php

namespace Mdojr\EmailProvider\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Mdojr\EmailProvider\View\Layout;

use Throwable;

class InternalServerError implements MiddlewareInterface
{
    use Helper\AcceptJson;

    private $layout;
    private $showError;

    public function __construct(Layout $layout, bool $showError)
    {
        $this->layout = $layout;
        $this->showError = $showError;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            $errorMessage =  'Erro inesperado';
            $errorTrace = [];

            if ($this->showError) {
                $errorMessage = sprintf('%s. %s %s', $e->getMessage(), $e->getFile(), $e->getLine());
                $errorTrace = $e->getTrace();
            }

            if ($this->acceptJson($request->getHeaderLine('accept'))) {

            } else {
                $this->layout
                    ->setLayout('layout-error')
                    ->render('http-error/500', [
                        'message' => $errorMessage,
                        'trace' => $errorTrace
                    ]);
            }
        }
    }
}
