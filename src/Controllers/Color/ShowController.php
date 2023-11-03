<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class ShowController extends AbstractController
{
    protected function run(): Response
    {
        // По аргументу получаем данные об этой категории
        $color = $this->colorRepo->filter([
            'id' => $this->args['color'],
            'single' => true
        ]);

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'color/show.twig', [
            'color' => $color,
        ]);
    }
}