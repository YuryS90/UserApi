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
        //$columns = $this->listByParams(self::REPO_USER_FIELD, [
        //    'column' => true
        //]);

        //$this->dd($this->setFieldOrder($columns, 'US'));
        //array:6 [▼
        //  "id" => "№"
        //  "email" => "Почта"
        //  "name" => "Имя"
        //  "address" => "Адрес"
        //  "roles_id" => "Роль"
        //  "is_email" => "Подтверждение"
        //]

        //array:10 [▼
        //  "id" => "№"
        //  "email" => "Почта"
        //  "password" => "Пароль"
        //  "name" => "Имя"
        //  "address" => "Адрес"
        //  "roles_id" => "Роль"
        //  "is_email" => "Подтверждение"
        //  "is_del" => "Удалён?"
        //  "created" => "Дата создания"
        //  "updated" => "Дата изменения"
        //]


        //$this->dd(array_column(
        //    $this->userRepo->getColumnsName(),
        //    "Comment",
        //    "Field"
        //));
        return $this->render($this->template, [
            // Пользователи с учётом их ролей
            'users' => $this->listByParams(self::REPO_USER, [
                'usersJoin' => true
            ]),
            // Имена полей в нужном порядке
            //'fields' => $this->setFieldOrder($columns, 'US')
            'fields' => array_column(
                $this->userRepo->getColumnsName(),
                "Comment",
                "Field"
            )
        ]);
    }
}