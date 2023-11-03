<?php

namespace App\Controllers\Tag;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class EditController extends AbstractController
{
    protected function run(): Response
    {
        // По аргументу получаем данные об этой категории
        $tag = $this->tagRepo->filter([
            'id' => $this->args['tag'],
            'single' => true
        ]);

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'tag/edit.twig', [
            'tag' => $tag,
        ]);
    }
}