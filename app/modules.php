<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

/** Регистрация модулей */
return [

    //'validMod' => function (ContainerInterface $container) {
    'validMod' => function () {
        //return new \App\Modules\Validator($container, $container->get('validate')['rules']);
        return new \App\Modules\Validate\Validator();
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

    'authMod' => function (ContainerInterface $container) {
        return new \App\Modules\Auth($container);
    },

];