<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * @property mixed|null $userRepo
 */
class IndexController extends AbstractController
{
    private string $template = 'user/index.twig';

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    protected function run(): Response
    {
        // Получаем список юзеров, которые не удалены
        $users = $this->userRepo->filter([
                'fields' => ['id', 'email', 'name', 'address', 'roles_id', 'is_email'],
                'joinRole' => [
                    'fields' => ['id_role', 'name_role'],
                ],
                'is_del' => 0
            ]) ?? [];

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, $this->template, [
            'users' => $users,
            'fields' => $this->fields ?? [],
        ]);
    }
}