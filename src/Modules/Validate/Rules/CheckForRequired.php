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
            'password_confirmation' => 'Заполните поле password_confirmation!',
            'name' => 'Заполните поле c именем!',
            'address' => 'Заполните поле c адресом!',
            'roles_id' => 'Необходимо выбрать роль!',

            'title' => 'Необходимо ввести название категории!',
            'parent_id' => 'Необходимо выбрать категорию!',

            'code' => 'Необходимо ввести цвет!',

            'article' => 'Необходимо ввести артикул!',
            'brand' => 'Необходимо ввести наименование товара!',
            'new_price' => 'Необходимо ввести актуальную цену!',
            'old_price' => 'Необходимо ввести старую цену!',
            'count' => 'Необходимо ввести количество товара!',
            'category_id' => 'Необходимо выбрать категорию!',
            'description' => 'Необходимо ввести описание товара!',
            'colors' => 'Необходимо выбрать цвет(а)!',
            'tags' => 'Необходимо выбрать тег(и)!',

            'user' => 'Некорректный ID',
            'category' => 'Некорректный ID',
            'color' => 'Некорректный ID',
            'tag' => 'Некорректный ID',
        ];

        return $messages[$name] ?? '';
    }
}