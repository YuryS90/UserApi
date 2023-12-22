<?php

namespace App\Modules\Validate;

use App\Common\ContainerTrait;
use App\Common\HelperTrait;

/** Класс проверки правописания данных */
class Validator
{
    use ContainerTrait, HelperTrait;

    private string $error = '';

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    public function validate(array $collection): string
    {
        foreach ($collection ?? [] as $name => $data) {
            // Проверяем наличие атрибута
            if (!isset($name)) {
                throw new \Exception('Пустая коллекция');
            }

            // Пропускаем атрибут password_confirmation
            if ($name === 'password_confirmation') {
                continue;
            }

            // Проверяем соответствие атрибута ключу правил
            $rules = $this->rules();
            if (!isset($rules[$name])) {
                throw new \Exception("Правило c атрибутом {$name} не зарегистрировано!");
            }

            // Если есть ошибки, прекращаем выполнение
            if (!empty($this->error)) {
                break;
            }

            // Получаем правила для атрибута
            $rules = $rules[$name];
            $confirm = "{$name}_confirmation";
            $dataConfirm = $collection[$confirm] ?? null;

            // Выполняем валидацию
            $this->execute($data, $rules, $name, $dataConfirm);
        }

        return $this->error;
    }

    /** @throws \Exception */
    public function execute(string $data, string $rules, string $name, ?string $dataConfirm = ''): void
    {
        // Разбиваем строку, напр. "required|string|max:255"
        $rules = explode('|', $rules);

        foreach ($rules as $rule) {
            // Получаем название правила и массив параметров (если есть)
            // array_pad(..., 2, null) переводит результат explode в массив длиной 2 элемента.
            // Если элементов в исходном массиве меньше 2, то он заполняет массив значениями null
            // до тех пор, пока длина массива не станет равной 2.
            [$ruleName, $ruleParams] = array_pad(explode(':', $rule, 2), 2, null);

            // Получаем объект правила через фабрику
            $ruleClass = ValidateFactory::create($ruleName, $this->container);
            if (!is_object($ruleClass)) {
                throw new \Exception("Объект с правилом {$ruleName}, {$ruleClass} не создан!");
            }

            // Если есть ошибки, прекращаем выполнение
            if (!empty($this->error)) {
                break;
            }

            // В каждом классе validate() возвращает bool - результат валидации
            if (!$ruleClass->validate($data, explode(',', $ruleParams), $dataConfirm)) {
                $this->error = $ruleClass->message($name, $ruleParams);
            }
        }
    }

    private function rules(): array
    {
        return [
            // Для пользователей
            'email' => 'required|string|email|min:5|max:255|unique:users,email',
            'password' => 'required|string|min:8|password|confirmed',
            'name' => 'required|string',
            'address' => 'required|string',
            'roles_id' => 'required|integer',

            // Для категорий
            'title' => 'required|string',
            'parent_id' => 'required|integer',

            // Для "{}" в маршрутах
            'user' => 'required|integer|zero|unique:users,id',
            'product' => 'required|integer|zero|unique:products,id',
            'category' => 'required|integer|zero|unique:categories,id',
        ];
    }
}