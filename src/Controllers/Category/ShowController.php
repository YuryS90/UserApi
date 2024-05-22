<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/** Отображение одной категории */
class ShowController extends AbstractController
{
    private string $template = 'category/show.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        $categories = $this->cache([
            'key' => self::KEY_CATEGORIES,
            'repo' => self::REPO_CATEGORY,
        ]);

        return $this->render($this->template, [
            'category' => $this->getCurrent($categories, $this->id)
        ]);
    }
}