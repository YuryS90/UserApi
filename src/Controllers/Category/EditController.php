<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/** Отображение формы на редактирование */
class EditController extends AbstractController
{
    private string $template = 'category/edit.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        $categories = $this->cache([
            'key' => self::KEY_CATEGORIES,
            'repo' => self::REPO_CATEGORY,
        ]);

        return $this->render($this->template, [
            'categories' => $this->buildTree2($categories),
            'categoryCurrent' => $categories[$this->id]
        ]);
    }
}