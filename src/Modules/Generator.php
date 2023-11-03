<?php

namespace App\Modules;

use App\Modules\Main\Module;
use Firebase\JWT\JWT;

class Generator extends Module
{
    // TODO Сделать статическим свойство, в которое поместим результат $this->generate['password']
    //      А после сделаем password() статическим
     /**
     * Генерация пароля
     * @throws \Exception
     */
    public function password(int $length = 10): string
    {
        $characters = $this->generate['password'];
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $password;
    }

    public function genToken(array $user): string
    {
        // TODO Как правильно генерировать токен, где его нужно хранить
        //      Как его использовать
        //      Вынести в конфиг
        //$this->dd($user);

        // Секретный ключ для подписи токена
        $key = 'my_secret_key';

        // Параметры (iss, aud, iat, nbf, exp) помогают контролировать безопасность и
        // проверить подлинность и целостность токена при его получении и обработке.
        $payload = [
            // Issuer указывает на издателя токена для проверки подлинности, т.е. идентифицирует приложение
            'iss' => 'my_issuer',

            // Audience определяет аудиторию или получателя токена,
            // представляющий идентификатор или URL-адрес аудитории моего приложения.
            'aud' => 'my_audience',

            // Время выдачи токена в формате Unix timestamp.
            // Обычно это текущее время или время начала действия токена.
            'iat' => time(),

            // Время в формате Unix timestamp, до которого токен не является действительным (не раньше, чем).
            // Т.е. токены, выпущенные до этого времени должны быть отклонены.
            'nbf' => time(),

            // Время истечения срока действия токена в формате Unix timestamp.
            // После истечения клиент должен повторно запросить новый токен
            'exp' => time() + (60 * 60), // истекает через 1 час
            //'exp' => time() + 86400 // истекает через 1 день

            'data' => [
                'id' => $user['id'],
                'login' => $user['login'],
                'email' => $user['email'],
                'rolesId' => $user['rolesId'],
            ]
        ];

        // Возвращаем токен
        return JWT::encode($payload, $key);
    }
}