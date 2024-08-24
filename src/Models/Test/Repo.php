<?php

namespace App\Models\Test;

use App\Database\Db;
use App\Models\AbstractModel;

class Repo extends AbstractModel
{
    protected static function getTable(): string
    {
        return 'test';
    }

    protected function applyCustomFilters(Db $query, array $params): void
    {
        if (isset($params['article'])) {
            $query->where('article=%s', $params['article']);
        }
    }

    protected function executeQuery(Db $query, array $params): ?array
    {
        $list = $query->exec()->list();
        return $list ?: null;
    }
}