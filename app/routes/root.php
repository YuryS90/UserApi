<?php
declare(strict_types=1);

return function ($app) {
    // Главная админки http://userapi
    $app->get('/', \App\Controllers\HomeController::class)->setName('home');

    $app->group('/api', include 'app/routes/api/api.php');

    $app->get('/test', \App\Controllers\TestController::class)->setName('test');

    // CRUD категорий, тегов, цветов, пользователей
    $app->group('/products', include 'app/routes/product/product.php');

    $app->group('/categories', include 'app/routes/category/category.php');

    $app->group('/tags', include 'app/routes/tag/tag.php');

    $app->group('/colors', include 'app/routes/color/color.php');

    $app->group('/users', include 'app/routes/user/user.php');
};