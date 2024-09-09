<?php

namespace App\Controllers\Api\User;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

class AuthorizationController extends AbstractController
{
    public function run(): Response
    {
        $request = $this->request->getParsedBody();

        // Валидировать на уникальность почты делать не нужно, т.к. клиента почта уже есть в БД
        // остаётся эту почту подтвердить
        //$request = $this->sanitization($request);
        //$error = $this->validated($request);

        // Получаем пользователя по переданной почте (проверка почты)
        $user = $this->getByParams(self::REPO_USER, [
            'email' => $request['email'] ?? '',
            'single' => true
        ]);

        // TODO вынести как правило валидации "verify"
        // Из БД по почте достаю пароль...
        if (password_verify($request['password'], $user['password'])) {

            // Если пароль подошёл, подтверждаю клиента почту, генерирую и отдаю токен
            if ($user['isEmail'] === 'Нет') {
                $this->update(self::REPO_USER, [
                    'id' => $user['id'],
                    'is_email' => 'Да',
                ]);
            }

            // Генерация токена
            $jwt = $this->genMod->createToken($user);

            return $this->responseJson(200, [
                'jwt' => $jwt,
                'data' => [
                    'id' => $user['id'],
                    'email' => $user['email'],
                ]
            ]);
        }

        return $this->responseJson(401, ['message' => 'Пользователь не авторизован!']);
    }
}