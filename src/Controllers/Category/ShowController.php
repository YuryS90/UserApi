<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

/** Отображение одной категории */
class ShowController extends AbstractController
{
    private string $template = 'category/show.twig';

    protected function run(): Response
    {
        return $this->render($this->template, [
            'category' => $this->getCategory($this->id) ?? [],
        ]);
    }
}