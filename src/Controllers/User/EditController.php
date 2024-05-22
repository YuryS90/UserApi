<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class EditController extends AbstractController
{
    private string $template = 'user/edit.twig';

    /**
     * @throws \Exception
     */
    protected function run(): Response
    {
        return $this->render($this->template, [
            'user' => $this->listByParams(self::REPO_USER, [
                'usersJoin' => true,
                'id' => $this->id
            ]),

            'roles' => $this->cache([
                'key' => self::KEY_USER_ROLES,
                'repo' => self::REPO_ROLE,
            ])
        ]);
    }
}