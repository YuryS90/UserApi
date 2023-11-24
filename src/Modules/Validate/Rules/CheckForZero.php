<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForZero extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        return $data >= 0;
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'user' => 'Некорректный ID',
        ];

        return $messages[$name] ?? '';
    }
}