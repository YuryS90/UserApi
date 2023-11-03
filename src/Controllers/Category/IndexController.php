<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

/** Отображение списка всех категорий */
class IndexController extends AbstractController
{
    protected function run(): Response
    {
        // Получаем список категорий
        $categories = $this->categoryRepo->filter([]);

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'category/index.twig', [
            'categories' => $categories,
        ]);
    }
}