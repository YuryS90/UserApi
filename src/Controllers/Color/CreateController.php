<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class CreateController extends AbstractController
{
    protected function run(): Response
    {
        $view = Twig::fromRequest($this->request);
        return $view->render($this->response, 'color/create.twig');
    }
}