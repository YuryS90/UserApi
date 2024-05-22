<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class ShowController extends AbstractController
{
    private string $template = 'color/show.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        return $this->render($this->template, [
            'color' => $this->getAllOrById(self::REPO_COLOR, $this->id)
        ]);
    }
}