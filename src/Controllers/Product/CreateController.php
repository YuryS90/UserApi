<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class CreateController extends AbstractController
{
    private string $template = 'product/create.twig';

    /**
     * @throws \Exception
     */
    protected function run(): Response
    {
        $categories = $this->cache([
            'key' => self::KEY_CATEGORIES,
            'repo' => self::REPO_CATEGORY,
        ]);

        return $this->render($this->template, [
            // Передаём дерево-категорий
            'categories' => $this->buildTree2($categories),
            'tags' => $this->getAllOrById(self::REPO_TAG),
            'colors' => $this->getAllOrById(self::REPO_COLOR),
        ]);
    }
}