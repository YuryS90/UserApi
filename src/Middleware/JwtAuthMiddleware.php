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
                // Аутентификация для всех внутренних маршрутов
                //"/",
                // Аутентификация для всех клиентских маршрутов
                "/api"
            ],
            // Исключение, где проверка аутентификации не нужна
            "ignore" => [
                "/api/users/signin",
                //"/api/users/me"
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