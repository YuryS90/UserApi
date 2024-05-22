<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForMin extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        return strlen($data) >= intval(current($params));
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'email' => "Email слишком короткий: минимум {$param} символов!",
            'password' => "Пароль должен содержать минимум {$param} символов!",
            'password_confirmation' => "Подтверждение пароля должен содержать минимум {$param} символов!",
        ];

        return $messages[$name] ?? '';
    }
}