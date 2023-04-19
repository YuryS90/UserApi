<?php
declare(strict_types=1);

return function ($app)
{
    // Маршруты пользователя
    $app->group('/user', include 'app/routes/user/user.php');
};
