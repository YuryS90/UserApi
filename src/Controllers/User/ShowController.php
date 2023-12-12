<?php

namespace App\Controllers\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null userFields
 * @property mixed|null $user
 */
class ShowController extends AbstractController
{
    private string $template = 'user/show.twig';

    protected function run(): Response
    {
        return $this->render($this->template, [
            'user' => $this->user ?? null,
            'fields' => $this->userFields ?? []
        ]);
    }
}