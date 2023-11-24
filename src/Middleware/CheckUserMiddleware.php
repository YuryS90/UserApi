<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;


class CheckUserMiddleware extends AbstractMiddleware
{
    public function run(): ResponseInterface
    {
        // TODO Маршрут http://userapi/users/100000/ будет недоступен обычному юзеру (checkUserMiddleware),
        //      поэтому можно не проверять на то, есть ли юзер с id=100000

        return $this->handle();
    }
}