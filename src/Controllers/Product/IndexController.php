<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null products
 */
class IndexController extends AbstractController
{
    private string $template = 'product/index.twig';

    protected function run(): Response
    {
        return $this->render($this->template, [
            'products' => $this->getAllOrById(self::REPO_PRODUCT),
            'fields' => array_column(
                $this->productRepo->getColumnsName(),
                "Comment",
                "Field"
            )
        ]);
    }
}