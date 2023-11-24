<?php

namespace App\Modules\Validate;

use Exception;
use Psr\Container\ContainerInterface;

class ValidateFactory
{
    // Регистрация правил
    private static array $rules = [
        'required' => ['class' => \App\Modules\Validate\Rules\CheckForRequired::class],
        'string' => ['class' => \App\Modules\Validate\Rules\CheckForStr::class],
        'integer' => ['class' => \App\Modules\Validate\Rules\CheckForInt::class],
        'zero' => ['class' => \App\Modules\Validate\Rules\CheckForZero::class],
        'email' => ['class' => \App\Modules\Validate\Rules\CheckForEmail::class],
        'password' => ['class' => \App\Modules\Validate\Rules\CheckForPassword::class],
        'min' => ['class' => \App\Modules\Validate\Rules\CheckForMin::class],
        'max' => ['class' => \App\Modules\Validate\Rules\CheckForMax::class],
        'size' => ['class' => \App\Modules\Validate\Rules\CheckForSize::class],
        'confirmed' => ['class' => \App\Modules\Validate\Rules\CheckForConfirm::class],
        'unique' => ['class' => \App\Modules\Validate\Rules\CheckForUnique::class],
    ];

    /** @throws Exception */
    public static function create(string $ruleName, ContainerInterface $container): ?object
    {
        $className = self::$rules[$ruleName]['class'] ?? null;

        if (!$className) {
            return null;
        }
        return new $className($container);
    }
}