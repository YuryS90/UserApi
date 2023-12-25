<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForRequired extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        return !empty(trim($data)) || $data == 0;
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'email' => 'Заполните поле email!',
            'password' => 'Заполните поле password!',
            'name' => 'Заполните поле c именем!',
            'address' => 'Заполните поле c адресом!',
            'roles_id' => 'Необходимо выбрать роль!',

            'title' => 'Необходимо ввести название категории!',
            'parent_id' => 'Необходимо выбрать категорию!',

            'user' => 'Некорректный ID',
            'category' => 'Некорректный ID',
        ];

        return $messages[$name] ?? '';
    }
}