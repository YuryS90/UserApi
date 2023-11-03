<?php

namespace App\Modules\Validate;

use Exception;

class ValidateFactory
{
    // Регистрация правил
    private static array $rules = [
        'required' => ['class' => \App\Modules\Validate\Rules\Required::class],
        'login' => ['class' => \App\Modules\Validate\Rules\Login::class],
        'min' => ['class' => \App\Modules\Validate\Rules\Min::class],
        'max' => ['class' => \App\Modules\Validate\Rules\Max::class],
        'unique' => ['class' => \App\Modules\Validate\Rules\Unique::class],
    ];

    /** @throws Exception */
    public static function create(string $ruleName): ?object
    {
        $className = self::$rules[$ruleName]['class'] ?? null;

        if (!$className) {
            return null;
        }
        return new $className();
    }
}