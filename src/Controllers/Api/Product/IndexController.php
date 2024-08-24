<?php

namespace App\Controllers\Api\Product;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class IndexController extends AbstractController
{
    protected function run(): Response
    {
        $urlParams = $this->getQueryParams() ?? [];

        $filterOptions = [];

        // Если есть параметр поиска, добавляем его в фильтр
        if (!empty($urlParams['searchTitle'])) {
            $filterOptions['search'] = $urlParams['searchTitle'];
        }

        // Карта сопоставления параметров сортировки с ключами фильтра
        $sortOptions = [
            'title' => 'orderByTitleAsc',
            'price' => 'orderByPriceAsc',
            '-price' => 'orderByPriceDesc',
        ];

        // Если есть параметр sortBy, проверяем его наличие в карте и устанавливаем соответствующий ключ
        if (!empty($urlParams['sortBy']) && isset($sortOptions[$urlParams['sortBy']])) {
            $filterOptions[$sortOptions[$urlParams['sortBy']]] = true;
        }

        // Выполняем один запрос с полученными параметрами
        $products = $this->testRepo->filter($filterOptions);

        return $this->responseJson(200, $products);
    }
}