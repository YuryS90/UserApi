<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [

    'validClass' => function (ContainerInterface $container) {
        return new \App\Modules\Validator($container);
    },

    'genClass' => function (ContainerInterface $container) {
        return new \App\Modules\Generator($container);
    },

    'mailClass' => function (ContainerInterface $container) {
        return new \App\Modules\Mail\Email($container->get('settings')['email']);
    }

];