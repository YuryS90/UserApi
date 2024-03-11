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
        return new \App\Middleware\Users\GetUsersOrUserMiddleware($container);
    },

    'rolesMiddleware' => function (ContainerInterface $container) {
        return new \App\Middleware\Users\GetRolesMiddleware($container);
    },

    'checkPathParameterMiddleware' => function (ContainerInterface $container) {
        return new \App\Middleware\CheckPathParameterMiddleware($container);
    },

    'getUserFieldsMiddleware' => function (ContainerInterface $container) {
        return new \App\Middleware\Users\GetUserFieldsMiddleware($container);
    },

    'getProductsOrProductMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\Products\GetProductsOrProductMiddleware($container);
    },

    'getProductFieldsMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\Products\GetProductFieldsMiddleware($container);
    },

];