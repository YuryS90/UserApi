<?php
declare(strict_types=1);

return function ($app)
{
    // http://userapi/api/orders
    $app->post('[/]', \App\Controllers\Api\Order\StoreController::class);
};