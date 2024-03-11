<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForRequired extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        return !empty(trim($data));
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

            'code' => 'Необходимо ввести цвет!',

            'user' => 'Некорректный ID',
            'category' => 'Некорректный ID',
            'color' => 'Некорректный ID',
        ];

        return $messages[$name] ?? '';
    }
}