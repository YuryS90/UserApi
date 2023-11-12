<?php

namespace App\Modules\Validate;

use App\Common\ContainerTrait;
use App\Common\HelperTrait;

abstract class AbstractValidate
{
    use ContainerTrait, HelperTrait;

    abstract public function validate(string $data, array $params = [], $dataConfirm = ''): bool;
}