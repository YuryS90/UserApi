<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;

/**
 * Проверка содержимого в {}
 * @property int $id
 */
class CheckPathParameterMiddleware extends AbstractMiddleware
{
    public function run(): ResponseInterface
    {
        $args = $this->getRouteArgs();

        if (!empty($args)) {

            $error = $this->validated($args, true);

            if (!empty($error)) {
                return $this->responseJson(422, [$error]);
            }

            $this->id = (int)current($args);
        }

        return $this->handle();
    }
}