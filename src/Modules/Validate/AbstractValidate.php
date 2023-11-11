<?php

namespace App\Modules\Validate;

use App\Common\ContainerTrait;
use App\Common\HelperTrait;
use App\Common\ServiceTrait;
use Psr\Container\ContainerInterface;

abstract class AbstractValidate
{
    use HelperTrait;

    abstract public function validate(string $data, array $params = [], $dataConfirm = ''): bool;
}