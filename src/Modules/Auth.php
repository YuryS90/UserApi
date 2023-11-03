<?php

namespace App\Modules;

use App\Modules\Main\Module;

/** Аутентификация учетных данных для предоставления доступа к системе */
class Auth extends Module
{
    const MSG_TYPE = 'auth';
    const MSG_KEY = 'unauth';

    public function auth(array $request): string
    {
        $list = $this->getListDb($request['email']);

        // Если данных о пользователе нет или не совпадает пароль
        if (empty($list) || !password_verify($request['password'], $list['pwd'])) {
            $message = $this->getMessage(self::MSG_TYPE, self::MSG_KEY);

            $this->log([
                'place' => get_class($this),
                'message' => $message,
                'email' => $request['email'],
            ], true);

            return $message;
        }

        // Меняем статус поля, если оно 0,
        if ($list['isEmailConfirmed'] === 0) {
            $this->userRepo->insertOrUpdate([
                'id' => $list['id'],
                'is_email_confirmed' => 1
            ]);
        }
        // Возвращаю токен
        return $this->genMod->genToken($list);
    }

    /** @return mixed */
    private function getListDb(string $email)
    {
        $params = [
            'email' => trim($email),
            'single' => true // метка, при которой возвращаем 1 запись
        ];
        return $this->userRepo->filter($params);
    }
}