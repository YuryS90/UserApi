<?php

namespace App\Modules;

use Exception;

class Validator extends MainModule
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];

    const MESSAGE_TYPE = 'validate';

    /**
     * Проверка пришедших данных от юзера
     * @throws Exception
     */
    public function validated(array $data = [], array $rules = []): string
    {
        if (empty($data) || empty($rules)) {
            throw new Exception($this->getMessage(self::MESSAGE_TYPE, 'empty'));
        }
        $this->data = $data;
        $this->rules = $rules;

        $this->parseRules();

        // Если есть ошибки, то подготавливаем к логу
        if (!empty($this->errors)) {
            $this->log([
                'place' => get_class($this),
                'message' => $this->errors,
                'login' => $data['login'],
                'email' => $data['email']
            ], true);
        }
        // Возвращаем либо ошибку, либо ничего
        return current($this->errors);
    }

    /**
     * @throws Exception
     */
    private function parseRules(): void
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
                $method = 'checkRule' . ucfirst(current($ruleParts));

                // Есть метод, напр ruleString() в классе Validator?
                if (method_exists($this, $method)) {

                    // *Формируем параметры валидации
                    //      Для required, string, email параметров нет - []
                    //      Для max:255/min:8 параметр будет 255/8 (ключ 0)
                    //      Для unique:users,email параметры: users(ключ 0) и email(ключ 1)
                    $params = $ruleParts[1] ? explode(',', $ruleParts[1]) : [];

                    $params = array_merge([$data], $params);

                    if (!$this->{$method}(...$params)) {
                        $this->addError($field, $rule);
                    }
                } else {
                    throw new Exception(
                        str_replace('rule', "$ruleParts[0]",
                            $this->getMessage(self::MESSAGE_TYPE, 'method')));
                }
            }
        }
    }

    /**
     * Добавление ошибки
     */
    public function addError(string $field, string $rule): void
    {
        // Отсекаем из правила то, что идёт после ":"
        if (preg_match('/:/', $rule)) {
            $rule = substr(strstr($rule, ':', true), 0);
        }
        $this->errors[] = $this->getMessage(self::MESSAGE_TYPE, "$field.$rule");
    }

    private function checkRuleRequired(string $value): bool
    {
        // Ошибка на  =>   '0', '', ' ', [], '  ', null
        return !empty(trim($value));
    }

    private function checkRuleString($value): bool
    {
        return is_string($value);
    }

    private function checkRuleLogin(string $login): bool
    {
        return preg_match('/^[\p{L}\p{N}_]+$/u', $login) === 1;
    }

    private function checkRuleEmail(string $email): bool
    {
        return preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/ui', trim($email)) === 1;
    }

    private function checkRuleMax(string $value, string $length): bool
    {
        return strlen($value) <= intval($length);
    }

    private function checkRuleMin(string $value, string $length): bool
    {
        return strlen($value) >= intval($length);
    }

    /**
     * Правило: unique:table,column, где column = $field
     * @throws Exception
     */
    private function checkRuleUnique(string $data, string $table, string $field): bool
    {
        if ($table === 'users') {

            // Формирование параметров для запроса в БД
            $params = [
                'fields' => ["COUNT({$field})"],
                'count' => true,
                $field => trim($data)
            ];

            // Результат запроса: SELECT COUNT(*) FROM users WHERE $field = $data
            $count = $this->userRepo->filter($params);
        } else {
            throw new Exception($this->getMessage(self::MESSAGE_TYPE, 'table'));
        }
        // 0 - нет в БД, 1 - есть в БД
        return $count === 0;
    }
}