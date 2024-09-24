<?php
declare(strict_types=1);

return function ($app)
{
    // Весь список закладок: http://userapi/api/favorites
    $app->get('[/]', \App\Controllers\Api\Favorite\IndexController::class);
    $app->post('[/]', \App\Controllers\Api\Favorite\StoreController::class);

    // http://userapi/api/favorites/1
    $app->delete('/{id}[/]', \App\Controllers\Api\Favorite\DeleteController::class);
};