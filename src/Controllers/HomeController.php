<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

class HomeController extends AbstractController
{
    private string $template = 'main/index.twig';

    protected function run(): Response
    {
        return $this->render($this->template);
    }
}