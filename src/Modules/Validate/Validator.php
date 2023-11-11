<?php

namespace App\Modules\Validate;

use App\Common\ContainerTrait;
use App\Common\HelperTrait;

/**
 * Класс проверки правописания данных
 *
 * Сюда нужно передать валидируемые данные и слаг, чтобы выбрать соответствующие требования для валидации данных
 * В rules() добавляем правила для каждого отдельного контроллера
 */
class Validator
{
    use ContainerTrait, HelperTrait;

    protected array $errors = [];

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    public function validate(array $collection, string $slug = '')
    {
       //$this->dd($this->userRepo->filter([]));

        // Нужно сохранять успешные данные в сессию под ключом почты
        $test = [
            "email" => 'sviridenkogmail.com',
            "password" => "12345678",
            "password_confirmation" => "12345",
            //"name" => "Анжела",
            //"address" => "Чкалова 49",
            //"roles_id" => "1",
        ];

        foreach ($test ?? [] as $name => $data) {
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
            if (!empty($this->errors)) {
                break;
            }

            // Получаем правила для атрибута
            $rules = $rules[$name];
            $confirm = "{$name}_confirmation";
            $dataConfirm = $test[$confirm] ?? null;

            // Выполняем валидацию
            $this->execute($data, $rules, $dataConfirm);
        }

        $this->dd($this->errors);
        // return errorHandler($this->errors); // выводим message
    }

    /** @throws \Exception */
    public function execute(string $data, string $rules, $dataConfirm = ''): void
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
            $ruleClass = ValidateFactory::create($ruleName);
            if (!is_object($ruleClass)) {
                throw new \Exception("Объект с правилом {$ruleName}, {$ruleClass} не создан!");
            }

            // Если есть ошибки, прекращаем выполнение
            if (!empty($this->errors)) {
                break;
            }

            // В каждом классе validate() возвращает bool - результат валидации
            if (!$ruleClass->validate($data, explode(',', $ruleParams), $dataConfirm)) {
                $this->errors[] = [$ruleClass, $data, explode(',', $ruleParams)];
            }
        }
    }

    private function rules(): array
    {
        // Добавить  password size:12 |unique:users,email
        return [
            'email' => 'required|string|email|min:5|max:255',
            //'email' => 'unique:users,email',
            'password' => 'required|string|confirmed',
        ];
    }
}