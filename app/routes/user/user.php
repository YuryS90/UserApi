<?php
declare(strict_types=1);

return function ($app)
{
    // Маршрут регистрации http://userapi/user/add
    $app->map(['*'], '/add[/]', \App\Controllers\User\CreateController::class);
};
