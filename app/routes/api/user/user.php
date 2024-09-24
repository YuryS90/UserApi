<?php
declare(strict_types=1);

return function ($app)
{
    // http://userapi/api/users/create
    $app->post('/create[/]', \App\Controllers\Api\User\StoreController::class);

    // http://userapi/api/users/me
    $app->post('/me[/]', \App\Controllers\Api\User\ProfileController::class);
};