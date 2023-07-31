<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;

class ServerMiddleware extends AbstractMiddleware
{
    public function run(): ResponseInterface
    {
        $this->ip = $this->request->getServerParams()['SERVER_ADDR'] ?? '';
        $this->userAgent = $this->request->getHeader('User-Agent')[0] ?? '';

        return $this->handle();
    }
}