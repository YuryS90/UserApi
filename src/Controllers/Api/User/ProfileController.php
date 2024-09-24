<?php

namespace App\Controllers\Api\User;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class ProfileController extends AbstractController
{
    public function run(): Response
    {
        // Заходит под одним и тем же клиентом 2 разных токена...
        try {
            // Если токен успешно декодирован и аутентификация прошла успешно,
            // содержимое декодированного токена сохраняется как jwt_token атрибут
            $decoded = $this->request->getAttribute('jwt_token');

            // Либо обратиться к БД чтобы отдать пользователя

            return $this->responseJson(200, [
                'data' => $decoded['data']
            ]);

        } catch (\Exception $e) {
            $this->dd("ERROR PROFILE: $e");
        }

        return $this->responseJson(401, ['message' => 'Пользователь не авторизован!']);
    }
}