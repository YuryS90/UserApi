<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $fields
 * @property mixed|null $user
 */
class ShowController extends AbstractController
{
    private string $template = 'user/show.twig';

    protected function run(): Response
    {
        $this->dd('show');
        return $this->render($this->template, [
            'user' => $this->user ?? null,
            'fields' => $this->fields ?? []
        ]);
    }
}