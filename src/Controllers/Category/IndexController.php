<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/** Отображение списка всех категорий*/
class IndexController extends AbstractController
{
    private string $template = 'category/index.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        $categories = $this->cache([
            'key' => self::KEY_CATEGORIES,
            'repo' => self::REPO_CATEGORY,
        ]);

        return $this->render($this->template, [
            'categories' => $this->buildTree2($categories)
        ]);
    }
}