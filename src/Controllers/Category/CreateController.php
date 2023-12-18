<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

/** Отображение формы на создание */
class CreateController extends AbstractController
{
    private string $template = 'category/create.twig';

    protected function run(): Response
    {
        return $this->render($this->template);
    }
}