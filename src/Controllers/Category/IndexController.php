<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/** Отображение списка всех категорий*/
class IndexController extends AbstractController
{
    private string $template = 'category/index.twig';

    protected function run(): Response
    {
        return $this->render($this->template, [
            'categories' => $this->getCategories() ?? [],
        ]);
    }
}