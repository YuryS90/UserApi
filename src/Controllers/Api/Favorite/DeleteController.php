<?php

namespace App\Controllers\Api\Favorite;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteController extends AbstractController
{
    protected function run(): Response
    {
        // 3) Запрос DELETE, в котором приходит строка product_id
        $this->favoritesRepo->remove($this->id) ?? [];

        return $this->responseJson(204, []);
    }
}