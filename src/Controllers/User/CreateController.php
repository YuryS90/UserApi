<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class CreateController extends AbstractController
{
    private string $template = 'user/create.twig';

    /**
     * @throws \Exception
     */
    protected function run(): Response
    {
        return $this->render($this->template, [
            'roles' => $this->cache([
                'key' => self::KEY_USER_ROLES,
                'repo' => self::REPO_ROLE,
            ])
        ]);
    }
}