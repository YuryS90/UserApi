<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForConfirm extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        return $data == $dataConfirm;
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'password' => 'Пароль должен быть подтверждён!'
        ];

        return $messages[$name] ?? '';
    }
}