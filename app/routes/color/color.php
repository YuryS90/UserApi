<?php
declare(strict_types=1);

return function ($app)
{
    // Весь список: http://userapi/colors/
    $app->get('[/]', \App\Controllers\Color\IndexController::class)->setName('color.index');

    // Форма добавления: http://userapi/colors/create
    $app->get('/create[/]', \App\Controllers\Color\CreateController::class)->setName('color.create');

    // Добавление: http://userapi/colors/
    $app->post('[/]', \App\Controllers\Color\StoreController::class)->setName('color.store');

    // Форма редактирования: http://userapi/colors/1/edit
    $app->get('/{color}/edit[/]', \App\Controllers\Color\EditController::class)->setName('color.edit');

    // Таблица из одного элемента: http://userapi/colors/1
    $app->get('/{color}[/]', \App\Controllers\Color\ShowController::class)->setName('color.show');

    // Изменение: http://userapi/colors/1
    $app->patch('/{color}[/]', \App\Controllers\Color\UpdateController::class)->setName('color.update');

    // Удаление: http://userapi/colors/1
    $app->delete('/{color}[/]', \App\Controllers\Color\DeleteController::class)->setName('color.delete');
};