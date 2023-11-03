<?php
declare(strict_types=1);

return function ($app)
{
    // Весь список: http://userapi/categories/
    $app->get('[/]', \App\Controllers\Category\IndexController::class)->setName('category.index');

    // Форма добавления: http://userapi/categories/create
    $app->get('/create[/]', \App\Controllers\Category\CreateController::class)->setName('category.create');

    // Добавление: http://userapi/categories/
    $app->post('[/]', \App\Controllers\Category\StoreController::class)->setName('category.store');

    // Форма редактирования: http://userapi/categories/1/edit
    $app->get('/{category}/edit[/]', \App\Controllers\Category\EditController::class)->setName('category.edit');

    // Таблица из одного элемента: http://userapi/categories/1
    $app->get('/{category}[/]', \App\Controllers\Category\ShowController::class)->setName('category.show');

    // Изменение: http://userapi/categories/1
    $app->patch('/{category}[/]', \App\Controllers\Category\UpdateController::class)->setName('category.update');

    // Удаление: http://userapi/categories/1
    $app->delete('/{category}[/]', \App\Controllers\Category\DeleteController::class)->setName('category.delete');
};