<?php

namespace App\Controllers\Tag;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class CreateController extends AbstractController
{
    protected function run(): Response
    {
        $view = Twig::fromRequest($this->request);
        return $view->render($this->response, 'tag/create.twig');
    }
}