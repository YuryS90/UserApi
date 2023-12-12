<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $user
 * @property mixed|null $roles
 */
class EditController extends AbstractController
{
    private string $template = 'user/edit.twig';

    protected function run(): Response
    {
        $this->dd('edit');
        return $this->render($this->template, [
            'user' => $this->user ?? null,
            'roles' => $this->roles,
        ]);
    }
}