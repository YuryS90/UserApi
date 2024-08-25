<?php

namespace App\Controllers\Api\Favorite;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class StoreController extends AbstractController
{
    protected function run(): Response
    {
        // 2) Запрос ПОСТ на создание объекта, в котором приходит объект с данными: product_id
        //    Ответ: вернуть созданный объект [{"id": 1, "product_id": 2}]
        $favorite = $this->request->getParsedBody();

        $id = $this->favoritesRepo->insertOrUpdate($favorite) ?? [];

        return $this->responseJson(201, ['id' => $id, 'message' => 'Добавлено в закладки!']);
    }
}