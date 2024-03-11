<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForNumeric extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        // Проверяем, что $data равно "0" или является числом
        return is_numeric($data);
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'parent_id' => 'Необходимо выбрать категорию!',
        ];

        return $messages[$name] ?? '';
    }
}