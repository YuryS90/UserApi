<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForPassword extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        $allowedChars = $this->generate['password'] ?? '';

        for ($i = 0; $i < strlen($data); $i++) {
            if (strpos($allowedChars, $data[$i]) === false) {
                return false;
            }
        }
        return true;
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'password' => 'Пароль содержит недопустимые символы!'
        ];

        return $messages[$name] ?? '';
    }
}