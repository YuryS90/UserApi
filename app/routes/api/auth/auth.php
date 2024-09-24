<?php
declare(strict_types=1);

return function ($app)
{
    // http://userapi/api/auth/login
    $app->post('/login[/]', \App\Controllers\Api\Auth\AuthorizationController::class);

    // http://userapi/api/auth/refresh-tokens
    $app->post('/refresh-tokens[/]', \App\Controllers\Api\Auth\RefreshController::class);

    // http://userapi/api/auth/logout
    $app->post('/logout[/]', \App\Controllers\Api\Auth\LogoutController::class);
};