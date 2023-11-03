<?php

namespace App\Modules;

use App\Modules\Main\Module;
use Exception;

/** Класс проверки правописания данных */
class Validator extends Module
{
    protected array $request;
    protected array $errors = [];

    const MSG_TYPE = 'validate';

    /** @throws Exception */
    public function validate(array $request, string $slug): string
    {
        if (empty($request) || empty($slug)) {
            // Клиенту показываем ошибку с кодом 500, а оишбку с ключом empty вывожу для себя
            throw new Exception($this->getMessage(self::MSG_TYPE, 'empty'));
        }
        $this->request = $request;

        $this->parseRules($slug);

        // Если есть ошибки, то подготавливаем к логу
        if (!empty($this->errors)) {
            $this->log([
                'place' => get_class($this),
                'message' => $this->errors,
                'login' => $request['login'],
                'email' => $request['email']
            ], true);

            // TODO
            //      Отдельно в одном месте делаю:
            //            $this->log([
            //                'place' => get_class($this),
            //                'message' => $this->errors,
            //                'login' => $request['login'] ?? null,
            //                'email' => $request['email'] ?? null
            //            ], true);
        }
        // Возвращаем либо ошибку, либо ничего
        return current($this->errors);
    }

    /** @throws Exception */
    private function parseRules(string $slug): void
    {
        foreach ($this->config[$slug] as $field => $value) {
            // *Данные введённые пользователем
            $data = $this->request[$field] ?? null;

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
                            $this->getMessage(self::MSG_TYPE, 'method')));
                }
            }
        }
    }

    /** Добавить ошибку */
    public function addError(string $field, string $rule): void
    {
        // Отсекаем из правила то, что идёт после ":"
        if (preg_match('/:/', $rule)) {
            $rule = substr(strstr($rule, ':', true), 0);
        }
        //$this->errors[] = $this->getMessage(self::MSG_TYPE, "$field.$rule");
        $this->errors[] = "$field.$rule";
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
        return preg_match('/^[\p{L}\p{N}_]+$/u', trim($login)) === 1;
    }

    private function checkRuleEmail(string $email): bool
    {
        return preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/ui', trim($email)) === 1;
    }

    /** Проверка чтобы все символы в $password совпадали с теми, что в config */
    private function checkRulePassword(string $password): bool
    {
        $allowedChars = $this->generate['password'] ?? '';

        for ($i = 0; $i < strlen($password); $i++) {
            if (strpos($allowedChars, $password[$i]) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $value Sp2wN499990
     * @param string $length 50
     */
    private function checkRuleMax(string $value, string $length): bool
    {
        return strlen($value) <= intval($length);
    }

    private function checkRuleMin(string $value, string $length): bool
    {
        return strlen($value) >= intval($length);
    }

    private function checkRuleSize(string $value, string $length): bool
    {
        return strlen($value) === intval($length);
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
            throw new Exception($this->getMessage(self::MSG_TYPE, 'table'));
        }
        // 0 - нет в БД, 1 - есть в БД
        return $count === 0;
    }
}