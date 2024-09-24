<?php

namespace App\Models\Status;

use App\Database\Db;
use App\Models\AbstractModel;

class Repo extends AbstractModel
{
    protected static function getTable(): string
    {
        return 'statuses';
    }

    protected function applyCustomFilters(Db $query, array $params): void
    {
    }

    protected function executeQuery(Db $query, array $params): ?array
    {
        $list = $query->exec()->listCamelCase('id');
        return $list ?: null;
    }
}