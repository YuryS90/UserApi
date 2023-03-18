<?php
return function ($app)
{
    // Маршрут регистрации http://userapi/user/add
    $app->map(['*'], '/add[/]', \App\Controllers\User\AddController::class);
};
