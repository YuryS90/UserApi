<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null userFields
 * @property mixed|null $users
 */
class IndexController extends AbstractController
{
    private string $template = 'user/index.twig';

    protected function run(): Response
    {
        return $this->render($this->template, [
            'users' => $this->users ?? [],
            'fields' => $this->userFields ?? [],
        ]);
    }
}