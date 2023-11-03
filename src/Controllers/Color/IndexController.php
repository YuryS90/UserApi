<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class IndexController extends AbstractController
{
    protected function run(): Response
    {
        // Получаем список тегов
        $colors = $this->colorRepo->filter([]);

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'color/index.twig', [
            'colors' => $colors,
        ]);
    }
}