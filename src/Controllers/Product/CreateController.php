<?php

namespace App\Controllers\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/** @property mixed|null $roles */
class CreateController extends AbstractController
{
    private string $template = 'product/create.twig';

    protected function run(): Response
    {
        return $this->render($this->template);
    }
}