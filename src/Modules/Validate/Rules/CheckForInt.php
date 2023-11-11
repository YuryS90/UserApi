<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForInt extends AbstractValidate
{
    /** @param mixed $data */
    public function validate($data, array $params = [], $dataConfirm = ''): bool
    {
        // Проверяем, является ли значение целым числом
        if (filter_var($data, FILTER_VALIDATE_INT) === false) {
            return false;
        }

        // Проверяем, что значение не является строкой, содержащей только цифры
        if (is_string($data) && !preg_match('/^\d+$/', $data)) {
            return false;
        }

        return true;
    }
}