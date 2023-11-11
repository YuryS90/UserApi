<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForConfirm extends AbstractValidate
{
    /** @param mixed $data */
    public function validate($data, array $params = [], $dataConfirm = ''): bool
    {
        return $data == $dataConfirm;
    }
}