<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [

    'valid' => function (ContainerInterface $container) {
        return new \App\Modules\Validator($container);
    }

];