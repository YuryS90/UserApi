<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/** @property mixed|null $roles */
class CreateController extends AbstractController
{
    private string $template = 'user/create.twig';

    protected function run(): Response
    {
        return $this->render($this->template, [
            'roles' => $this->roles ?? []
        ]);
    }
}