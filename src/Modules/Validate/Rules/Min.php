<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class Min extends AbstractValidate
{
    public function validate(string $data, array $params = []): bool
    {
        return strlen($data) >= intval(current($params));
    }
}