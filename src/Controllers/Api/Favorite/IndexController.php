<?php

namespace App\Controllers\Api\Favorite;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends AbstractController
{
    protected function run(): Response
    {
        // 1) Запрос ГЕТ на получение всех закладок
        //    Ответ: [{"id": 1, "product_id": 2}, {"id": 2, "product_id": 9} ...]
        $favorites = $this->favoritesRepo->filter([]) ?? [];

        return $this->responseJson(200, $favorites);
    }
}