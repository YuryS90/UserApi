<?php

namespace App\Controllers\Color;

use App\Controllers\AbstractController;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

/** @property mixed|null $id */
class DeleteController extends AbstractController
{
    /** @throws \Exception */
    protected function run(): Response
    {
        $this->delete(self::COLOR, $this->id);

        return ResourceSuccess::make(200, 'Запись удалена!');
    }
}