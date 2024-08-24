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

    'productRepo' => function (ContainerInterface $container) {
        return new \App\Models\Product\Repo($container);
    },

    'galleryRepo' => function (ContainerInterface $container) {
        return new \App\Models\Gallery\Repo($container);
    },

    'productTagsRepo' => function (ContainerInterface $container) {
        return new \App\Models\ProductTag\Repo($container);
    },

    'colorProductsRepo' => function (ContainerInterface $container) {
        return new \App\Models\ColorProduct\Repo($container);
    },

    'testRepo' => function (ContainerInterface $container) {
        return new \App\Models\Test\Repo($container);
    },

    'favoritesRepo' => function (ContainerInterface $container) {
        return new \App\Models\Favorite\Repo($container);
    },

];