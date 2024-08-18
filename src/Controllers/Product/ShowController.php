<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $fields
 * @property mixed|null $user
 */
class ShowController extends AbstractController
{
    private string $template = 'product/show.twig';

    protected function run(): Response
    {

        // TODO http://userapi/products/api - такого пути нет, но перешло на show

        return $this->render($this->template, [
            //'user' => $this->user ?? null,
            //'fields' => $this->fields ?? []
        ]);
    }
}