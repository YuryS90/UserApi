<?php

namespace App\Modules\Validate;

use App\Common\HelperTrait;

abstract class AbstractValidate
{
    use HelperTrait;

    abstract public function validate(string $data, array $params = []): bool;
}