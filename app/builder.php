<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

/**
 * Регистрация класса для работы с БД
 */
return [

    'db' => function (ContainerInterface $container) {
        return new \App\Database\Db($container->get('environments')['dev']);
    }

];
