<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $categories
 */
class CreateController extends AbstractController
{
    private string $template = 'product/create.twig';

    protected function run(): Response
    {
        //$this->dd($this->getCategories());
        return $this->render($this->template, [
            'categories' => $this->categories ?? [],
        ]);
    }
}