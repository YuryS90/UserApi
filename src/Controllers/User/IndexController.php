<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends AbstractController
{
    private string $template = 'user/index.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        // Имена полей таблицы users
        $columns = $this->listByParams(self::REPO_USER_FIELD, [
            'column' => true
        ]);

        return $this->render($this->template, [
            // Пользователи с учётом их ролей
            'users' => $this->listByParams(self::REPO_USER, [
                'usersJoin' => true
            ]),
            // Имена полей в нужном порядке
            'fields' => $this->setFieldOrder($columns, 'US')
        ]);
    }
}