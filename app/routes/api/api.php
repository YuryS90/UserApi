<?php
declare(strict_types=1);

return function ($app)
{
    // Весь список: http://userapi/api/products?price=123
    // Сортировка: http://userapi/api/products?sortBy=price
    // Фильтрация и сортировка: http://userapi/api/products?sortBy=price&searchTitle=nike
    $app->get('/products[/]', \App\Controllers\Api\Product\IndexController::class);


    // Весь список закладок: http://userapi/api/favorites
    $app->get('/favorites[/]', \App\Controllers\Api\Favorite\IndexController::class);
    $app->post('/favorites[/]', \App\Controllers\Api\Favorite\StoreController::class);
    // http://userapi/api/favorites/1
    $app->delete('/favorites/{id}[/]', \App\Controllers\Api\Favorite\DeleteController::class);


    // http://userapi/api/orders
    $app->post('/orders[/]', \App\Controllers\Api\Order\StoreController::class);

    // http://userapi/api/users/signup
    $app->post('/users/signup[/]', \App\Controllers\Api\User\StoreController::class);
    $app->post('/users/signin[/]', \App\Controllers\Api\User\AuthorizationController::class);
    $app->post('/users/me[/]', \App\Controllers\Api\User\ProfileController::class);
};