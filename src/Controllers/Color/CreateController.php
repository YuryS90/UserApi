<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class CreateController extends AbstractController
{
    private string $template = 'color/create.twig';

    protected function run(): Response
    {
        return $this->render($this->template);
    }
}