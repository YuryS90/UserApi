<?php

namespace App\Models\ProductTag;

use App\Database\Db;
use App\Models\AbstractModel;

class Repo extends AbstractModel
{
    protected static function getTable(): string
    {
        return 'product_tags';
    }

    protected function applyCustomFilters($query, array $params): void
    {
    }

    protected function executeQuery(Db $query, array $params): ?array
    {
        $list = $query->exec()->list();
        return $list ?: null;
    }
}