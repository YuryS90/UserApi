<?php

namespace App\Controllers\Tag;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class ShowController extends AbstractController
{
    private string $template = 'tag/show.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        return $this->render($this->template, [
            'tag' => $this->getAllOrById(self::REPO_TAG, $this->id)
        ]);
    }
}