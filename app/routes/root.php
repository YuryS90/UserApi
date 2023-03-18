<?php
return function ($app)
{
    // Группа маршрутов пользователя
    $app->group('/user', include 'app/routes/user/user.php');
};
