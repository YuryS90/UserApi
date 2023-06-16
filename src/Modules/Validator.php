<?php

namespace App\Modules;


class Validator extends MainModule
{
    protected array $data;
    protected array $rules;
    private array $errors = [];

    // Возвращаем массив: пустой или с ошибками
    public function validated(array $data, array $rules): array
    {
        if (empty($data) || empty($rules)) {
            return [
                'error' => true,
                'message' => 'Запрос пустой или нет правил!'
            ];
        }

        $this->data = $data;
        $this->rules = $rules;

        $this->parseRule();

        return $this->errors;
    }

    private function parseRule(): void
    {
        foreach ($this->rules as $field => $value) {

            // *Данные введённые пользователем
            $data = $this->data[$field] ?? null;

            // Разбиваем строку, напр. "required|string|max:255"
            $rules = explode('|', $value);

            // Проходим по всем правилам текущего поля
            foreach ($rules as $rule) {

                // Разбиваем строку на название правила (max) и его параметр(ы) (255)
                $ruleParts = explode(':', $rule);

                // *Название метода валидации
                $method = 'rule' . ucfirst(current($ruleParts));

                // Есть метод, напр ruleString() в классе Validator?
                if (method_exists($this, $method)) {

                    // *Формируем параметры валидации
                    // Для required, string, email параметров нет - []
                    // Для max:255/min:8 параметр будет 255/8 (ключ 0)
                    // Для unique:users,email параметры: users(ключ 0) и email(ключ 1)
                    $params = $ruleParts[1] ? explode(',', $ruleParts[1]) : [];

                    $params = array_merge([$data], $params);

                    if (!$this->{$method}(...$params)) {
                        $this->addError($field, $rule);
                    }

                } else {
                    die(json_encode("Метод для {$ruleParts[0]} не создан!", JSON_UNESCAPED_UNICODE));
                }
            }
        }
    }

    private function addError(string $field, string $rule): void
    {
        // Отсекаем из правила то, что идёт после ":"
        if (preg_match('/:/', $rule)) {
            $rule = substr(strstr($rule, ':', true), 0);
        }

        $this->errors += [
            'error' => true,
            'message' => $this->validate['message']["$field.$rule"]
        ];

    }

    private function ruleRequired(string $value): bool
    {
        // Ошибка на  =>   '0', '', ' ', [], '  ', null
        return !empty(trim($value));
    }

    private function ruleString($value): bool
    {
        return is_string($value);
    }

    private function ruleLogin(string $login): bool
    {
        return preg_match('/^[\p{L}\p{N}_]+$/u', $login) === 1;
    }

    private function ruleEmail(string $email): bool
    {
        return preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/ui', trim($email)) === 1;
    }


    private function ruleMax(string $value, string $length): bool
    {
        return strlen($value) <= intval($length);
    }

    private function ruleMin(string $value, string $length): bool
    {
        return strlen($value) >= intval($length);
    }

    // unique:table,column
    private function ruleUnique(string $data, string $table, string $field): bool
    {
        if ($table === 'users') {

            // Формирование параметров для запроса в БД
            $params = [];

            if ($field === 'email' || $field === 'login') {
                $params[$field] = trim($data);
            }

            $params += [
                'fields' => ['COUNT(*)'],
                'count' => true,
            ];

            // Результат запроса: SELECT COUNT(*) FROM users WHERE $field = $data
            $count = $this->userRepo->filter($params);
        } else {
            die(json_encode('Такой таблицы нет!', JSON_UNESCAPED_UNICODE));
        }

        // 0 - нет в БД, 1 - есть в БД
        return $count === 0;
    }
}