<?php
declare(strict_types=1);

return function ($app)
{
    // Главная страница API http://userapi
    $app->get('/', \App\Controllers\HomeController::class)->setName('home');

    // CRUD категорий, тегов, цветов, пользователей
    $app->group('/categories', include 'app/routes/category/category.php');
    $app->group('/tags', include 'app/routes/tag/tag.php');
    $app->group('/colors', include 'app/routes/color/color.php');
    $app->group('/users', include 'app/routes/user/user.php')
        ->add('fieldsMiddleware');
};