<?php

namespace App\Exception;

use App\Common\ContainerTrait;
use App\Common\ServiceTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Handlers\ErrorHandler;
use Slim\Interfaces\ErrorHandlerInterface;

class NotFound extends ErrorHandler implements ErrorHandlerInterface
{
    use ServiceTrait, ContainerTrait;

    private \Slim\Psr7\Response $response;

    public function __invoke(
        \Psr\Http\Message\ServerRequestInterface $request,
        \Throwable                               $exception,
        bool                                     $displayErrorDetails,
        bool                                     $logErrors,
        bool                                     $logErrorDetails
    ): Response
    {
       return $this->respondException(404, $exception);
    }
}