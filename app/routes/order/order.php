<?php
declare(strict_types=1);

return function ($app)
{
    // Весь список: http://userapi/orders/
    $app->get('[/]', \App\Controllers\Order\IndexController::class)->setName('order.index');

    // Таблица из одного элемента: http://userapi/orders/1
    $app->get('/{order}[/]', \App\Controllers\Order\ShowController::class)->setName('order.show');
};