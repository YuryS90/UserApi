<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @property mixed|null $roleRepo
 */
class CreateController extends AbstractController
{
    private string $template = 'user/create.twig';

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function run(): Response
    {
        // Получить роли
        $roles = $this->roleRepo->filter([]) ?? [];

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, $this->template, [
            'roles' => $roles
        ]);
    }
}