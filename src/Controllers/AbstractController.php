<?php

namespace App\Controllers;

use App\Common\CacheTrait;
use App\Common\SafetyTrait;
use App\Common\ServiceTrait;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @property mixed|null $validMod
 * @property mixed|null $categoryRepo
 * @property mixed|null $colorRepo
 * @property mixed|null $cacheMod
 */
abstract class AbstractController
{
    use CacheTrait, ServiceTrait, SafetyTrait;

    protected Request $request;
    protected \Slim\Psr7\Response $response;
    protected array $args;

    protected const COLOR = 'color';
    protected const CATEGORY = 'category';
    protected const CACHE_TREE = 'tree';
    protected const CACHE_CATEGORY_LIST = 'list';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        return $this->run();
    }

    abstract protected function run(): Response;
}