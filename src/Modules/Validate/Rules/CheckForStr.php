<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForStr extends AbstractValidate
{
    /** @param mixed $data */
    public function validate($data, array $params = [], $dataConfirm = ''): bool
    {
        return is_string($data);
    }
}