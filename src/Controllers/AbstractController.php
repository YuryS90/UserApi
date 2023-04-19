<?php

namespace App\Controllers;

use App\Common\ContainerTrait;
use App\Common\HelperTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class AbstractController
{
    use ContainerTrait, HelperTrait;

    protected Request $request;
    protected Response $response;
    protected array $args;

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        return $this->run();
    }

    abstract protected function run(): Response;
}