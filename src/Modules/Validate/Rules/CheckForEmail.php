<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForEmail extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        return preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/ui', trim($data)) === 1;
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'email' => 'Email должен соответствовать формату mail@some.com!'
        ];

        return $messages[$name];
    }
}