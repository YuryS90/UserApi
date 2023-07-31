<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

/**
 * Регистрация промежуточных ПО
 */
return [

    'exceptionMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\ExceptionMiddleware($container);
    },

    'serverMiddleware' => function (ContainerInterface $container) {
        return new App\Middleware\ServerMiddleware($container);
    },

];