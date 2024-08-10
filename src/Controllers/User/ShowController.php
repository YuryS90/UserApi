<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class ShowController extends AbstractController
{
    private string $template = 'user/show.twig';

    /**
     * @throws \Exception
     */
    protected function run(): Response
    {
        // Имена полей таблицы users
        //$columns = $this->listByParams(self::REPO_USER_FIELD, [
        //    'column' => true
        //]);

        return $this->render($this->template, [
            // Пользователь + название его роли
            'user' => [$this->listByParams(self::REPO_USER, [
                'usersJoin' => true,
                'id' => $this->id
            ])],
            // Имена полей в нужном порядке
            //'fields' => $this->setFieldOrder($columns, 'US'),
            // Параметр URL
            'urlParam' => $this->id
        ]);
    }
}