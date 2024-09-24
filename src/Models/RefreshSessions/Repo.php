<?php

namespace App\Models\RefreshSessions;

use App\Database\Db;
use App\Models\AbstractModel;

class Repo extends AbstractModel
{
    protected static function getTable(): string
    {
        return 'refresh_sessions';
    }

    protected function applyCustomFilters(Db $query, array $params): void
    {
        if (isset($params['refresh_token'])) {
            $query->where('refresh_token=%s', $params['refresh_token']);
        }
    }

    protected function executeQuery(Db $query, array $params): ?array
    {
        $list = $query->exec()->listCamelCase('id');
        return $list ?: null;
    }


}