<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

/** @property mixed|null $db */
class CheckForUnique extends AbstractValidate
{
    public function validate(string $data, array $params = [], ?string $dataConfirm = ''): bool
    {
        // TODO Если юзер удалён ('is_del' => 1) и при попытке через урл ввести его id
        //      http://userapi/users/6/, то выкинуть сообщение "пользователь недоступен"
        //SELECT EXISTS (SELECT 1 FROM {$table} WHERE {$field} = %s AND is_del = 0)

        [$table, $field] = $params;

        $q = $this->db->build("SELECT EXISTS (SELECT 1 FROM {$table} WHERE {$field} = %s AND is_del = 0)", $data);

        if ($field === 'id') {
            return ($q->exec()->result()) === 1;
        }

        // 0 - нет в БД, 1 - есть в БД
        return ($q->exec()->result()) === 0;
    }

    public function message(string $name, ?string $param): string
    {
        $messages = [
            'email' => 'Пользователь с таким email уже существует!',

            'user' => 'Такого пользователя нет!',
            'product' => 'Такого товара нет!',
            'category' => 'Такой категории нет!',
        ];

        return $messages[$name] ?? '';
    }
}