<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

/** Отображение формы на редактирование */
class EditController extends AbstractController
{
    private string $template = 'category/edit.twig';

    protected function run(): Response
    {//$this->dd($this->categories);
        // По аргументу получаем данные об этой категории
        $category = $this->categoryRepo->filter([
            'id' => $this->args['category'],
            'single' => true
        ]);

        $view = Twig::fromRequest($this->request);

        return $view->render($this->response, 'category/edit.twig', [
            'category' => $category,
        ]);

        //return $this->render($this->template, [
        //    'categories' => $this->categories ?? [],
        //]);
    }
}