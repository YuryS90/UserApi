<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForMax extends AbstractValidate
{
    public function validate(string $data, array $params = [], $dataConfirm = ''): bool
    {
        return strlen($data) <= intval(current($params));
    }
}