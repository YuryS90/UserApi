<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

/**
 * Регистрация модулей
 */
return [

    'validMod' => function (ContainerInterface $container) {
        return new \App\Modules\Validator($container);
    },

    'genMod' => function (ContainerInterface $container) {
        return new \App\Modules\Generator($container);
    },

    'mailMod' => function (ContainerInterface $container) {
        return new \App\Modules\Mail\Email($container, $container->get('settings')['email']);
    },

    'logMod' => function (ContainerInterface $container) {
        return new \App\Modules\Log\ActionLog($container);
    },

];