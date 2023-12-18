<?php

namespace App\Controllers;

use App\Common\ContainerTrait;
use App\Common\ModelTrait;
use App\Common\SafetyTrait;
use App\Common\ServiceTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @property mixed|null $validMod
 * @property mixed|null $categoryRepo
 */
abstract class AbstractController
{
    use ContainerTrait, ServiceTrait, SafetyTrait, ModelTrait;

    protected Request $request;
    protected \Slim\Psr7\Response $response;
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