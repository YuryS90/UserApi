<?php

namespace App\Controllers\Api\Auth;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Каждый раз обновляю refresh token в момент просрочки access token'a.
 * На случай, если юзер будет в offline более 30 дней, тогда придется заново вбить логин/пароль.
 */
class RefreshController extends AbstractController
{
    public function run(): Response
    {
        // Получаю с Vue fingerprint
        //$request = $this->request->getParsedBody();

//        $refreshToken = $_COOKIE['refresh_token'] ?? null;
//
//        if (!$refreshToken) {
//            // Нет refresh token в куках
//            return $this->responseJson(401, [
//                'error' => true,
//                'message' => 'NO_REFRESH_TOKEN'
//            ]);
//        }

        // По UUID'у refresh токена получаю все поля с данными о сессии
//        $sessionRef = $this->refreshSessionsRepo->filter([
//
//            // Преобразование в бинарный формат, иначе данные не получим
//            'refresh_token' => hex2bin($refreshToken),
//            'single' => true
//        ]);

        // Если по UUID refresh токен сессия не найдена
//        if (empty($sessionRef)) {
//            return $this->responseJson(401, [
//                'error' => true,
//                'message' => 'INVALID_REFRESH_TOKEN'
//            ]);
//        }

        // Получаем текущее время в миллисекундах. Т.к. $sessionRef['expiresIn'] тоже в мс
//        $currentTimestamp = round(microtime(true) * 1000);
//
//        // Проверка срока жизни токена и соответствия fingerprint
//        if ($currentTimestamp > $sessionRef['expiresIn']) {
//            // Время жизни refresh токена истекло
//            $errorMessage = 'TOKEN_EXPIRED';
//
//        } elseif ($sessionRef['fingerprint'] !== $request['fingerprint']) {
//            // fingerprint не совпадают (против хакера)
//            $errorMessage = 'INVALID_REFRESH_SESSION';
//        }
//
//        if (isset($errorMessage)) {
//            return $this->responseJson(401, [
//                'error' => true,
//                'message' => $errorMessage
//            ]);
//        }

        // Сравниваем refresh token из запроса с токеном в БД
//        if ($refreshToken !== bin2hex($sessionRef['refreshToken'])) {
//            // Токены не совпадают
//            return $this->responseJson(401, [
//                'error' => true,
//                'message' => 'INVALID_REFRESH_TOKEN.'
//            ]);
//        }

        // В случае успеха обновляем refresh-сессию
        //$this->db->query('UPDATE refresh_sessions SET
        //         refresh_token = UUID_TO_BIN(UUID()),
        //         expiresIn = UNIX_TIMESTAMP(NOW()) * 1000 + 2592000000 WHERE id=%d', $sessionRef['id']);

        // Получаем обновлённую сессию по id
        //$sessionRef = $this->refreshSessionsRepo->filter([
        //    'id' => $sessionRef['id'],
        //    'single' => true
        //]);

        // Получаю пользователя (может c Vue отправлять просроченный jwt, чтобы брать инфу о user?
        // передав через бирер а тут сделать $decoded = $this->request->getAttribute('jwt_token');)
        // Также извлечь и сравить данные просроченного access токена с $user[id]
        $user = $this->getByParams(self::REPO_USER, [
            //'id' => $sessionRef['userId'] ?? '',
            'id' => 14,
            'single' => true
        ]);

        // Генерация нового access токена
        $accessToken = $this->genMod->createToken($user);

        // Преобразование бинарного значения в строку
//        $refreshToken = bin2hex($sessionRef['refreshToken']);
//
//        // Получаю время в миллисекундах
//        $expiresIn = $sessionRef['expiresIn'];
//
//        // Преобразую в секунды
//        $expiresInSeconds = $expiresIn / 1000;
//
//        $cookieParams = [
//            'domain' => 'userapi',
//            'path' => '/api/auth',
//            'httponly' => true,
//            'expires' => $expiresInSeconds
//        ];
//
//        setcookie('refresh_token', $refreshToken, $cookieParams);

        return $this->responseJson(200, [
            'accessToken' => $accessToken ?? null,
        ]);
    }
}