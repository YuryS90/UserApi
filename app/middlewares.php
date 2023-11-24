<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

/** Регистрация промежуточных ПО */
return [

    'exceptionMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\ExceptionMiddleware($container);
    },

    'serverMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\ServerMiddleware($container);
    },

    'getUsersOrUserMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\GetUsersOrUserMiddleware($container);
    },

    'rolesMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\GetRolesMiddleware($container);
    },

    'checkPathParameterMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\CheckPathParameterMiddleware($container);
    },

    'getUserColumnsMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\GetUserColumnsMiddleware($container);
    },

];