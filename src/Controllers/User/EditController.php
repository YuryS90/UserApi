<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class EditController extends AbstractController
{
    private string $template = 'user/edit.twig';

    protected function run(): Response
    {
        $id = (int)$this->args['user'];

        // TODO
        //      Проверка на то если пользователя нет в БД, например, если в args будет 100000,
        //       то выбросить исключение или 404
        //      Проверить $id на 0
        //      Обработать пришедшие данные! $request и $this->args

        // По аргументу получаем данные о пользователе
        $user = $this->userRepo->filter([
                'fields' => ['id', 'name', 'address', 'roles_id'],
                'id' => $id,
                'joinRole' => [
                    'fields' => ['id_role', 'name_role'],
                ],
                'single' => true
            ]) ?? [];

        $roles = $this->roleRepo->filter([]);

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, $this->template, [
            'user' => $user,
            'roles' => $roles,
        ]);
    }
}