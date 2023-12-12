<?php
declare(strict_types=1);

return function ($app)
{
    // Весь список: http://userapi/products/
    $app->get('[/]', \App\Controllers\Product\IndexController::class)->setName('product.index');

    // Форма добавления: http://userapi/products/create
    $app->get('/create[/]', \App\Controllers\Product\CreateController::class)->setName('product.create');

    // Добавление: http://userapi/products/
    $app->post('[/]', \App\Controllers\Product\StoreController::class)->setName('product.store');

    // Форма редактирования: http://userapi/products/1/edit
    $app->get('/{product}/edit[/]', \App\Controllers\Product\EditController::class)->setName('product.edit');

    // Таблица из одного элемента: http://userapi/products/1
    $app->get('/{product}[/]', \App\Controllers\Product\ShowController::class)->setName('product.show');

    // Изменение: http://userapi/products/1
    $app->patch('/{product}[/]', \App\Controllers\Product\UpdateController::class)->setName('product.update');

    // Удаление: http://userapi/products/1
    $app->delete('/{product}[/]', \App\Controllers\Product\DeleteController::class)->setName('product.delete');
};