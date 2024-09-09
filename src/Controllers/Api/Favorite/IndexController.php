<?php

namespace App\Controllers\Api\Favorite;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends AbstractController
{
    protected function run(): Response
    {
        $urlParams = $this->getQueryParams() ?? [];

        $favorites = $this->favoritesRepo->filter([]) ?? [];

        // Вернуть все закладки в урезанном формате чтобы просто клиент смог отобразить нужную svg
        $response = $favorites;

        // Если передаётся _relations, то возвращаются закладки в формате чтобы клиент отобразил товары
        if (!empty($urlParams['_relations'])) {
            $products = $this->testRepo->filter([]) ?? [];

            // Обновление массива, в котором ключи меняются на значения из столбца 'id'
            $products = array_column($products, null, 'id');

            // Фильтрует все $favorites, оставляя только те элементы, для которых условие будет true
            $favorites = array_filter(
                $favorites,
                fn($favorite) => isset($products[$favorite['test_id']])
            );

            // Отфильтрованный массив преобразуется в нужный формат для отображения всех данных товара
            // На каждой итерации для каждого элемента fn возвращает соответствующий элемент по ключу test_id.
            $response = array_map(
                fn($favorite) => $products[$favorite['test_id']],
                $favorites
            );
        }

        return $this->responseJson(200, $response);
    }
}