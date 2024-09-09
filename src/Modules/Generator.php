<?php

namespace App\Modules;

use App\Modules\Main\Module;
use Firebase\JWT\JWT;

/**
 * @property mixed|null $jwt
 * @property mixed|null $generate
 */
class Generator extends Module
{
    // TODO Сделать статическим свойство, в которое поместим результат $this->generate['password']
    //      А после сделаем password() статическим
     /**
     * Генерация пароля
     * @throws \Exception
     */
    public function createPassword(int $length = 10): string
    {
        $characters = $this->generate['password'];
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $password;
    }

    public function createToken(array $user): string
    {
        // Секретный ключ для подписи токена
        $key = $this->jwt['secret'];

        // Параметры (iss, aud, iat, nbf, exp) помогают контролировать безопасность и
        // проверить подлинность и целостность токена при его получении и обработке.
        $payload = [
            // Issuer указывает на издателя токена для проверки подлинности, т.е. идентифицирует приложение
            'iss' => 'http://userapi',

            // Audience определяет аудиторию или получателя токена,
            // представляющий идентификатор или URL-адрес аудитории моего приложения.
            'aud' => ['http://localhost:5173', 'http://userapi'],

            // Время выдачи токена в формате Unix timestamp.
            // Обычно это текущее время или время начала действия токена.
            'iat' => time(),

            // Время в формате Unix timestamp, до которого токен не является действительным (не раньше, чем).
            // Т.е. токены, выпущенные до этого времени должны быть отклонены.
            'nbf' => time(),

            // Время истечения срока действия токена в формате Unix timestamp.
            // После истечения клиент должен повторно запросить новый токен
            //'exp' => time() + (60 * 60), // истекает через 1 час
            'exp' => time() + 60, // истекает через 1 мин
            //'exp' => time() + 86400 // истекает через 1 день

            'data' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'rolesId' => $user['rolesId'],
            ]
        ];

        // Возвращаем токен
        return JWT::encode($payload, $key);
    }
}