<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class Login extends AbstractValidate
{
    public function validate(string $data, array $params = []): bool
    {
        return preg_match('/^[\p{L}\p{N}_]+$/u', trim($data)) === 1;
    }
}