<?php

namespace App\Modules\Validate;

use App\Common\HelperTrait;
use Exception;

/**
 * Класс проверки правописания данных
 *
 * Сюда нужно передать валидируемые данные и слаг, чтобы выбрать соответствующие требования для валидации данных
 * В rules() добавляем правила для каждого отдельного контроллера
 */
class Validator
{
    use HelperTrait;

    //protected array $errors = [];

    public function validate(array $data, string $slug)
    {
        $payload = [
            'data' => $data ?? [],
            'rules' => $this->rules()[$slug] ?? [],
        ];

        $this->parseRules($payload);

        // Возвращаем либо ошибку, либо ничего
        //return current($this->errors);
    }

    private function rules(): array
    {
        return [
            // Правила для регистрации
            'register' => [
                //'login' => 'required|login|min:5|max:50|unique:users,login',
                'login' => 'unique:users,login',
                'email' => 'required|string|email|min:5|max:255|unique:users,email',
            ],
            // Правила для авторизации
            'auth' => [
                'email' => 'required|string|email|min:5|max:255',
                'password' => 'required|string|password|size:12'
            ]
        ];
    }

    /** @throws Exception */
    private function parseRules(array $payload): void
    {
        foreach ($payload['rules'] as $field => $value) {

            // *Данные введённые пользователем
            $data = $payload['data'][$field] ?? null;
            // Разбиваем строку, напр. "required|string|max:255"
            $rules = explode('|', $value);


            foreach ($rules as $rule) {

                $ruleParts = explode(':', $rule);

                $ruleName = current($ruleParts);
                $ruleParams = $ruleParts[1] ? explode(',', $ruleParts[1]) : [];

                //$params = array_merge([$data], $ruleParams);

                $ruleClass = ValidateFactory::create($ruleName);

                if (!is_object($ruleClass)) {
                    throw new Exception("Объект с правилом {$ruleParts[0]} не создан!");
                }

                if (!$ruleClass->validate($data, $ruleParams)) {
                    $this->dd('Ошибка');
                }
            }
        }
    }

}