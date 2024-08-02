<?php

namespace App\Models;

interface ModelInterface
{
    public function insertOrUpdate(array $params): void;
    public function filter(array $params): ?array;
}