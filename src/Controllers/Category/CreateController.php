<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

/** Отображение формы на создание */
class CreateController extends AbstractController
{
    protected function run(): Response
    {
        $view = Twig::fromRequest($this->request);
        return $view->render($this->response, 'category/create.twig');
    }
}