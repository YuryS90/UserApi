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
 * @property mixed|null $id
 */
abstract class AbstractController
{
    use CacheTrait, ServiceTrait, SafetyTrait;

    protected Request $request;
    protected \Slim\Psr7\Response $response;
    protected array $args;

    protected const REPO_COLOR = 'color';
    protected const REPO_CATEGORY = 'category';
    protected const REPO_TAG = 'tag';
    protected const REPO_USER = 'user';
    protected const REPO_ROLE = 'role';
    protected const REPO_PRODUCT = 'product';
    protected const REPO_GALLERY = 'gallery';
    protected const REPO_PRODUCT_TAGS = 'productTags';
    protected const REPO_COLOR_PRODUCTS = 'colorProducts';
    protected const REPO_REFRESH_SESSIONS = 'refreshSessions';

    protected const KEY_CATEGORIES = 'categories';
    protected const KEY_USER_ROLES = 'user_roles';

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        return $this->run();
    }

    abstract protected function run(): Response;
}