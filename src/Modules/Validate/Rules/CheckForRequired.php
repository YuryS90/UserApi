<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForRequired extends AbstractValidate
{
    public function validate(string $data, array $params = [], $dataConfirm = ''): bool
    {
        return !empty(trim($data));
    }
}