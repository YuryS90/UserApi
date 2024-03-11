<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForColor extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', trim($data)) === 1;
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'code' => 'Цвет должен соответствовать формату #000000'
        ];

        return $messages[$name];
    }
}