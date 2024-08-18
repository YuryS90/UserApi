<?php
declare(strict_types=1);

return function ($app)
{
    // Весь список: http://userapi/api/
    $app->get('[/]', \App\Controllers\Api\IndexController::class);
};