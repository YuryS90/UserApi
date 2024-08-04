<?php

namespace App\Modules\Validate;

use App\Common\ContainerTrait;
use App\Common\HelperTrait;

/** Класс проверки правописания данных */
class Validator
{
    use ContainerTrait, HelperTrait;

    private string $error = '';
    private string $key = '';

    /** @throws \Exception */
    public function validate(array $collection, bool $url = false): string
    {
        if (!$this->hasAttr($collection)) {
            throw new \Exception("Правило c атрибутом {$this->key} не зарегистрировано!");
        }

        // Валидация параметров URL
        if ($url) {
            $this->execute([
                'value' => current($collection),
                'name' => key($collection)
            ]);
            return $this->error;
        }

        // Валидация html полей
        foreach ($collection as $name => $value) {
            if ($name === 'password_confirmation') {
                continue;
            }

            // Если есть ошибка, прекращаем выполнение
            if (!empty($this->error)) {
                break;
            }

            $confirm = ($name === 'password') ? ($collection['password_confirmation'] ?? null) : null;

            $this->execute([
                'value' => $value,
                'name' => $name,
                'confirm' => $confirm,
            ]);
        }
        return $this->error;
    }

    /** @throws \Exception */
    public function execute(array $payload): void
    {
        // Разбиваем строку, напр. "required|string|max:255"
        $rules = explode('|', $this->rules()[$payload['name']]);

        foreach ($rules as $rule) {
            // Получаем название правила и массив параметров (если есть)
            // array_pad(..., 2, null) переводит рез-т explode в массив длиной 2 элемента.
            // Если эл-тов в исходном массиве меньше 2, то он заполняет массив значениями null
            // до тех пор, пока длина массива не станет равной 2.
            [$ruleName, $ruleParams] = array_pad(explode(':', $rule, 2), 2, null);

            // Получаем объект правила через фабрику
            $ruleClass = ValidateFactory::create($ruleName, $this->container);

            if (!is_object($ruleClass)) {
                throw new \Exception("Класс CheckFor<???> с соответствующим правилом не создан!");
            }

            // Если есть ошибки, прекращаем выполнение
            if (!$ruleClass->validate($payload['value'], explode(',', $ruleParams), $payload['confirm'] ?? null)) {
                $this->error = $ruleClass->message($payload['name'], $ruleParams);
                break;
            }
        }
    }

    /**
     * Поиск зарегистрированного атрибута в rules()
     * @throws \Exception
     */
    private function hasAttr(array $collection): bool
    {
        $rules = array_keys($this->rules());

        foreach ($collection as $key => $value) {
            // Если ключ отсутствует во втором массиве, возвращаем false
            if (!in_array($key, $rules)) {
                $this->key = $key;
                return false;
            }
        }
        return true;
    }

    /** Поля подчинённые зарегистрированным правилам */
    private function rules(): array
    {
        return [
            // Для пользователей
            'email' => 'required|string|email|min:5|max:255|unique:users,email',
            'password' => 'required|string|min:8|password|confirmed',
            'password_confirmation' => null,
            'name' => 'required|string',
            'address' => 'required|string',
            'roles_id' => 'required|integer',

            // Для категорий
            'title' => 'required|string',
            'parent_id' => 'numeric|integer',

            // Для цветов
            'code' => 'required|string|color|unique:colors,code',

            // Для товаров
            'article' => 'required|integer|unique:products,article',
            'brand' => 'required|string',
            'new_price' => 'required|decimal:2',
            'old_price' => 'required|decimal:2',
            'count' => 'required|integer',
            'category_id' => 'required|integer',
            'description' => 'required',
            'colors' => 'required',
            'tags' => 'required',

            // Для аргументов "{}" в url
            'user' => 'required|integer|zero|unique:users,id',
            'product' => 'required|integer|zero|unique:products,id',
            'category' => 'required|integer|zero|unique:categories,id',
            'color' => 'required|integer|zero|unique:colors,id',
            'tag' => 'required|integer|zero|unique:tags,id',
        ];
    }
}