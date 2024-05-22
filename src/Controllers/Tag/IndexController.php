<?php

namespace App\Controllers\Tag;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends AbstractController
{
    private string $template = 'tag/index.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        return $this->render($this->template, [
            'tags' => $this->getAllOrById(self::REPO_TAG)
        ]);
    }
}