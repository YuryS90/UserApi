<?php
declare(strict_types=1);

return function ($app)
{
//    // Маршрут регистрации http://userapi/user/add
//    $app->map(['*'], '/add[/]', \App\Controllers\Auth\CreateController::class);
//
//    // Маршрут авторизации http://userapi/user/auth
//    $app->map(['*'], '/auth[/]', \App\Controllers\Auth\AuthorizationController::class);
//
//    // Маршрут комнаты пользователя http://userapi/user/profile
//    $app->map(['*'], '/profile[/]', \App\Controllers\ProfileController::class);

    // Весь список: http://userapi/users/
    $app->get('[/]', \App\Controllers\User\IndexController::class)->setName('user.index');

    // Форма добавления: http://userapi/users/create
    $app->get('/create[/]', \App\Controllers\User\CreateController::class)->setName('user.create');

    // Добавление: http://userapi/users/
    $app->post('[/]', \App\Controllers\User\StoreController::class)->setName('user.store');

    // Форма редактирования: http://userapi/users/1/edit
    $app->get('/{user}/edit[/]', \App\Controllers\User\EditController::class)->setName('user.edit');

    // Таблица из одного элемента: http://userapi/users/1
    $app->get('/{user}[/]', \App\Controllers\User\ShowController::class)->setName('user.show');

    // Изменение: http://userapi/users/1
    $app->patch('/{user}[/]', \App\Controllers\User\UpdateController::class)->setName('user.update');

    // Удаление: http://userapi/users/1
    $app->delete('/{user}[/]', \App\Controllers\User\DeleteController::class)->setName('user.delete');
};
