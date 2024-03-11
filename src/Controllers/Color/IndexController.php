<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends AbstractController
{
    private string $template = 'color/index.twig';

    /** @throws Exception */
    protected function run(): Response
    {
        return $this->render($this->template, [
            'colors' => $this->getAllOrSingle(self::COLOR) ?? [],
        ]);
    }
}