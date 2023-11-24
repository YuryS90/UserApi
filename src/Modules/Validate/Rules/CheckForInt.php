<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForInt extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        // Проверяем, является ли значение целым числом
        if (!is_numeric($data)) {
            return false;
        }

        // Проверяем, что значение не является строкой, содержащей только цифры
        if (is_string($data) && !preg_match('/^\d+$/', $data)) {
            return false;
        }

        return true;
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'roles_id' => 'Роль должна соответствовать целочисленному типу!',
            'user' => 'Некорректный ID',
        ];

        return $messages[$name] ?? '';
    }
}