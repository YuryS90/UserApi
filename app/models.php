<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

/** Регистрация моделей */
return [

    'userRepo' => function (ContainerInterface $container) {
        return new \App\Models\User\Repo($container);
    },

    'roleRepo' => function (ContainerInterface $container) {
        return new App\Models\Role\Repo($container);
    },

    'categoryRepo' => function (ContainerInterface $container) {
        return new \App\Models\Category\Repo($container);
    },

    'tagRepo' => function (ContainerInterface $container) {
        return new \App\Models\Tag\Repo($container);
    },

    'colorRepo' => function (ContainerInterface $container) {
        return new \App\Models\Color\Repo($container);
    },

    'userFieldRepo' => function (ContainerInterface $container) {
        return new \App\Models\User\Field\Repo($container);
    },

    'productFieldRepo' => function (ContainerInterface $container) {
        return new \App\Models\Product\Field\Repo($container);
    },

    'productRepo' => function (ContainerInterface $container) {
        return new \App\Models\Product\Repo($container);
    },

];