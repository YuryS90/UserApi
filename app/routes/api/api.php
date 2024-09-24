<?php
declare(strict_types=1);

return function ($app)
{
    $app->group('/auth', include 'app/routes/api/auth/auth.php');

    $app->group('/users', include 'app/routes/api/user/user.php');

    $app->group('/products', include 'app/routes/api/product/product.php');

    $app->group('/favorites', include 'app/routes/api/favorite/favorite.php');

    $app->group('/orders', include 'app/routes/api/order/order.php');
};