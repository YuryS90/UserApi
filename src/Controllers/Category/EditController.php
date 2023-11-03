<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

/** Отображение формы на редактирование */
class EditController extends AbstractController
{
    protected function run(): Response
    {
        // По аргументу получаем данные об этой категории
        $category = $this->categoryRepo->filter([
            'id' => $this->args['category'],
            'single' => true
        ]);

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'category/edit.twig', [
            'category' => $category,
        ]);
    }
}