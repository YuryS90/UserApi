<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForDecimal extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        // Проверка на числовое значение
        if (!is_numeric($data)) {
            return false;
        }

        // Опциональная дробная часть должна начинаться с точки и иметь от 1 до $params[0]
        $pattern = "/^\d+(\.\d{1,{$params[0]}})?$/";
        return preg_match($pattern, $data) > 0;
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'new_price' => "Неверный формат цены. При необходимости знак \".\" и до сотых. Примеры: 100, 100.0, 100.10, 0.10",
            'old_price' => "Неверный формат цены. При необходимости знак \".\" и до сотых. Примеры: 100, 100.0, 100.10, 0.10",
        ];

        return $messages[$name] ?? '';
    }
}