<?php
declare(strict_types=1);

return function ($app)
{
    // Весь список: http://userapi/api/products?price=123
    // Сортировка: http://userapi/api/products?sortBy=price
    // Фильтрация и сортировка: http://userapi/api/products?sortBy=price&searchTitle=nike
    $app->get('[/]', \App\Controllers\Api\Product\IndexController::class);
};