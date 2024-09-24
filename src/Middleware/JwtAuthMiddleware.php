<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Tuupola\Middleware\JwtAuthentication;

/**
 * @property mixed|null $jwt
 */
class JwtAuthMiddleware extends AbstractMiddleware
{
    public function run(): ResponseInterface
    {
        // Конфигурация JwtAuthentication
        $jwtMiddleware = new JwtAuthentication([
            "path" => [
                // Доступ для всех маршрутов
                //"/",
                // Доступ только для api-маршрутов
                "/api"
            ],
            // Исключение, где проверка аутентификации не нужна
            "ignore" => [
                "/api/users/create",
                "/api/auth/login",
                "/api/auth/refresh-tokens",
                "/api/auth/logout",

                // Даю доступ к получению продуктов на гл стр клиента
                "/api/products",
            ],
            // Имя атрибута, в котором будет храниться декодированная информация о токене
            "attribute" => "jwt_token",

            "secret" => $this->jwt['secret'],

            // false для работы на http (в dev среде). На production должен быть true
            "secure" => false,

            // При неудачной аутентификации
            "error" => function (ResponseInterface $response, $arguments) {
                $data["status"] = "error";
                $data["message"] = $arguments["message"];

                $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));

                return $response->withHeader('Content-Type', 'application/json; charset=UTF-8');
            }
        ]);

        // Запускаем middleware JWT для обработки запроса
        return $jwtMiddleware->process($this->request, $this->handler);
    }
}