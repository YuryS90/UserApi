<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForMax extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        return strlen($data) <= intval(current($params));
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'email' => "Email слишком длинное: максимум {$param} символов!",
        ];

        return $messages[$name] ?? '';
    }
}