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
            $argsKey = key($args);

            $id = $this->getRouteArgument($argsKey);

            // Валидация
            $error = $this->validated([$argsKey => $id]);

            if (!empty($error)) {
                return $this->responseJson(422, [$error]);
            }

            $this->id = (int)$id;
        }

        return $this->handle();
    }
}