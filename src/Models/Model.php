<?php

namespace App\Models;

use App\Common\ContainerTrait;
use App\Common\ServiceTrait;

/**
 * @property mixed|null $db
 * @property mixed|null $roleRepo
 */
class Model
{
    use ContainerTrait, ServiceTrait;
}