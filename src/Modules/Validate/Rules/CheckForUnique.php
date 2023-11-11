<?php

namespace App\Modules\Validate\Rules;

use App\Modules\Validate\AbstractValidate;

class CheckForUnique extends AbstractValidate
{
    public function validate(string $data, array $params = [], $dataConfirm = ''): bool
    {
        $this->dd($this->userRepo->filter([]), 123);
        [$table, $field] = $params;

        if ($table === 'users') {

            // Формирование параметров для запроса в БД
            $params = [
                'fields' => ["COUNT({$field})"],
                'count' => true,
                $field => trim($data)
            ];
            $this->dd($params, $this->userRepo);

            // Результат запроса: SELECT COUNT(*) FROM users WHERE $field = $data
            $count = $this->userRepo->filter($params);
        } else {
            throw new \Exception($this->getMessage(self::MSG_TYPE, 'table'));
        }
        // 0 - нет в БД, 1 - есть в БД
        return $count === 0;
    }
}