<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

/** Регистрация модулей */
return [
    'validMod' => function (ContainerInterface $container) {
        return new \App\Modules\Validate\Validator($container);
    },

    //'validMod2' => function (ContainerInterface $container) {
    //    return new \App\Modules\Validate\AbstractValidate($container);
    //},

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