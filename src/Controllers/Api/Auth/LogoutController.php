<?php

namespace App\Controllers\Api\Auth;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * accessToken становиться не актуальным по истечению срока
 */
class LogoutController extends AbstractController
{
    public function run(): Response
    {
        $refreshToken = $_COOKIE['refresh_token'] ?? null;

        if (!empty($refreshToken)) {
            // По UUID'у refresh токена получаю id сессии
            $sessionId = $this->refreshSessionsRepo->filter([
                'fields' => ['id'],

                // Преобразование в бинарный формат, иначе данные не получим
                'refresh_token' => hex2bin($refreshToken),
                'single' => true
            ]);

            // Удаление сессии
            $this->db->query('DELETE FROM refresh_sessions WHERE id=%d', $sessionId['id']);

            // Очистка куки
            $cookieParams = [
                'domain' => 'userapi',
                'path' => '/api/auth',
                'httponly' => true,

                // Время истечения куки указывает на прошедшую дату (1 час назад), что заставляет браузер удалить её
                'expires' => time() - 3600
            ];

            setcookie('refresh_token', '', $cookieParams);
        }

        return $this->responseJson(200, ['message' => 'Пользователь вышел с системы']);
    }
}