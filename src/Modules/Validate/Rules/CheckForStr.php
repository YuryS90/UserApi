<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForStr extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        return is_string($data);
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'email' => 'Email должен соответствовать строчному типу!',
            'password' => 'Пароль должен соответствовать строчному типу!',
            'name' => 'Имя должно соответствовать строчному типу!',
            'address' => 'Адрес должен соответствовать строчному типу!',

            'title' => 'Название категории должно соответствовать строчному типу!',
        ];

        return $messages[$name] ?? '';
    }
}