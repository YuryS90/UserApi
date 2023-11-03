<?php
declare(strict_types=1);

return function ($app)
{
    // Весь список: http://userapi/tags/
    $app->get('[/]', \App\Controllers\Tag\IndexController::class)->setName('tag.index');

    // Форма добавления: http://userapi/tags/create
    $app->get('/create[/]', \App\Controllers\Tag\CreateController::class)->setName('tag.create');

    // Добавление: http://userapi/tags/
    $app->post('[/]', \App\Controllers\Tag\StoreController::class)->setName('tag.store');

    // Форма редактирования: http://userapi/tags/1/edit
    $app->get('/{tag}/edit[/]', \App\Controllers\Tag\EditController::class)->setName('tag.edit');

    // Таблица из одного элемента: http://userapi/tags/1
    $app->get('/{tag}[/]', \App\Controllers\Tag\ShowController::class)->setName('tag.show');

    // Изменение: http://userapi/tags/1
    $app->patch('/{tag}[/]', \App\Controllers\Tag\UpdateController::class)->setName('tag.update');

    // Удаление: http://userapi/tags/1
    $app->delete('/{tag}[/]', \App\Controllers\Tag\DeleteController::class)->setName('tag.delete');
};