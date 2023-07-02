<?php
declare(strict_types=1);

use Psr\Container\ContainerInterface;

return [

    'exceptionMiddleware' => function () {
        return new App\Middleware\ExceptionMiddleware();
    }

];