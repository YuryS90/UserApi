<?php

namespace App\Middleware;

use App\Common\ContainerTrait;
use App\Common\SafetyTrait;
use App\Common\ServiceTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

abstract class AbstractMiddleware
{
    use ContainerTrait, ServiceTrait, SafetyTrait;

    protected Request $request;
    protected RequestHandler $handler;

    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $this->request = $request;
        $this->handler = $handler;

        return $this->run();
    }

    abstract protected function run(): ResponseInterface;

    public function handle(): ResponseInterface
    {
        return $this->handler->handle($this->request);
    }
}