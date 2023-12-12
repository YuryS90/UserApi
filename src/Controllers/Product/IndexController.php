<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null products
 * @property mixed|null $productFields
 */
class IndexController extends AbstractController
{
    private string $template = 'product/index.twig';

    protected function run(): Response
    {//$this->dd($this->product);
        return $this->render($this->template, [
            'users' => $this->products ?? [],
            'fields' => $this->productFields ?? [],
        ]);
    }
}