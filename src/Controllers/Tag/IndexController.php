<?php

namespace App\Controllers\Tag;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class IndexController extends AbstractController
{
    protected function run(): Response
    {
        // Получаем список тегов
        $tags = $this->tagRepo->filter([]);

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'tag/index.twig', [
            'tags' => $tags,
        ]);
    }
}