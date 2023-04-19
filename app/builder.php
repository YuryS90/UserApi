<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [

    'db' => function (ContainerInterface $container) {
        return new \App\Database\Db($container->get('environments')['dev']);
    }

];
