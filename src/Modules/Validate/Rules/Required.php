<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class Required extends AbstractValidate
{
    public function validate(string $data, array $params = []): bool
    {
        return !empty(trim($data));
    }
}