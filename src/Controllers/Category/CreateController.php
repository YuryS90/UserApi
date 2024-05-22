<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/** Отображение формы на создание */
class CreateController extends AbstractController
{
    private string $template = 'category/create.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        $categories = $this->cache([
            'key' => self::KEY_CATEGORIES,
            'repo' => self::REPO_CATEGORY,
        ]);

        return $this->render($this->template, [
            // Передаём дерево-категорий
            'categories' => $this->buildTree2($categories)
        ]);
    }
}