<?php

namespace App\Models;

interface ModelInterface
{
    public function insertOrUpdate(array $params);
    public function filter(array $params): ?array;
}