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
        return $this->render($this->template, [
            // Пользователи с названием ролей
            'users' => $this->listByParams(self::REPO_USER, [
                'usersJoin' => true
            ]),
           'fields' => array_column(
               $this->userRepo->getColumnsName(),
               "Comment",
               "Field"
           )
        ]);
    }
}