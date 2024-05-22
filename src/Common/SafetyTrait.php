<?php

namespace App\Common;

trait SafetyTrait
{
    use HelperTrait;

    public function sanitization(array $request): array
    {
        // Исключаем лишние ключи. array_flip() - значения становятся ключами
        $unsetValue = ['_METHOD', 'csrf_name', 'csrf_value'];
        $request = array_diff_key($request, array_flip($unsetValue));

        $collection = [];
        foreach ($request as $field => $data) {
            $collection[$field] = htmlspecialchars($data, ENT_QUOTES);
        }

        return $collection;
    }

    public function validated(array $request, bool $url = false): string
    {
        return $this->validMod->validate($request, $url);
    }

    // TODO: Создать триггер на подобное &lt;script&gt;Test&lt;/script&gt;
}