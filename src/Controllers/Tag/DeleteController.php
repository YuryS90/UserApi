<?php

namespace App\Controllers\Tag;

use App\Controllers\AbstractController;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteController extends AbstractController
{
    /** @throws \Exception */
    protected function run(): Response
    {
        $this->delete(self::REPO_TAG, $this->id);
        return ResourceSuccess::make(200, 'Запись удалена!');
    }
}