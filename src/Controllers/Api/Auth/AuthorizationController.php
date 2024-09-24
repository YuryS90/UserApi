<?php

namespace App\Controllers\Api\Auth;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

class AuthorizationController extends AbstractController
{
    public function run(): Response
    {
        // Принимаю данные
        $request = $this->request->getParsedBody();

        // Валидировать на уникальность почты делать не нужно, т.к. клиента почта уже есть в БД
        // остаётся эту почту подтвердить
        //$request = $this->sanitization($request);
        //$error = $this->validated($request);

        // Перед этим проверка, что пришедшая почта есть, если есть, то получаем пользователя.
        // Получаем пользователя по переданной почте (проверка почты)
        $user = $this->getByParams(self::REPO_USER, [
            'email' => $request['email'] ?? '',
            'single' => true
        ]);

        // TODO вынести как правило валидации "verify"
        //      $user может быть пустым
        // Сверяю пароль из БД с паролем, что был отправлен на почту (при регистрации)
        if (password_verify($request['password'], $user['password'])) {

            // Если пароль подошёл и если почта не подтверждена, то подтверждаю
            if ($user['isEmail'] === 'Нет') {
                $this->update(self::REPO_USER, [
                    'id' => $user['id'],
                    'is_email' => 'Да',
                ]);
            }

            // Перед этим проверка, есть ли такая сессия.
            // проверять сколько рефреш-сессий всего есть у юзера (до 5 одновременных рефреш-сессий максимум)
            //при попытке установить следующую удаляю предыдущие кроме последней

            // Добавление новой сессии и получения её id
//            $sessionId = $this->db->query('INSERT INTO refresh_sessions SET
//                                user_id = %d:user_id,
//                                refresh_token = UUID_TO_BIN(UUID()),
//                                fingerprint = %s:fingerprint,
//                                expiresIn = UNIX_TIMESTAMP(NOW()) * 1000 + 2592000000',
//                [
//                    'user_id' => $user['id'] ?? null,
//                    'fingerprint' => $request['fingerprint'] ?? null,
//                ]
//            )->id();

            // По id сессии получаем её все данные
            //$sessionRef = $this->refreshSessionsRepo->filter([
            //    'id' => (int)$sessionId,
            //    'single' => true
            //]);

            // Преобразование бинарного значения в строку
            //$refreshToken = bin2hex($sessionRef['refreshToken']);


            //array:9 [
            //  "id" => 8
            //  "userId" => 14
            //  "refreshToken" => b"ÄµÚÔsˆ\x11ï´I\x04|\x16\x00\x1AN"
            //  "ua" => null
            //  "fingerprint" => "d71be9e928c83e0a5a103c51855bfed4"
            //  "ip" => null
            //  "expiresIn" => 1729013672000
            //  "created" => "2024-09-15 20:34:32"
            //  "updated" => null
            //]
            //"c4b5dad4738811efb449047c16001a4e"
            // e4193618740311ef9312047c16001a4e

            // Генерация токена
            $accessToken = $this->genMod->createToken($user);

            // Получаю время в миллисекундах
            //$expiresIn = $sessionRef['expiresIn'];

            // Преобразую в секунды
            //$expiresInSeconds = $expiresIn / 1000;

            //$cookieParams = [
            //    'domain' => 'userapi',
            //    'path' => '/api/auth',
            //    'httponly' => true,
            //    'expires' => $expiresInSeconds
            //];

            //setcookie('refresh_token', $refreshToken, $cookieParams);

            return $this->responseJson(200, [
                'accessToken' => $accessToken,
                'data' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                ]
            ]);
        }

        return $this->responseJson(401, ['message' => 'Пользователь не авторизован!']);
    }
}