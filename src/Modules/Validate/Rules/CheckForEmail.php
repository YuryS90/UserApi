<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForEmail extends AbstractValidate
{
    public function validate(string $data, array $params = [], $dataConfirm = ''): bool
    {
        return preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/ui', trim($data)) === 1;
    }
}