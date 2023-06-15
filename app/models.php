<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [

    'userRepo' => function (ContainerInterface $container) {
        return new \App\Models\User\Repo($container);
    }

];