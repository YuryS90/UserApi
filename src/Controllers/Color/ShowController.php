<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @property mixed|null $id
 */
class ShowController extends AbstractController
{
    private string $template = 'color/show.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        return $this->render($this->template, [
            'color' => $this->getAllOrSingle(self::COLOR, $this->id) ?? []
        ]);
    }
}