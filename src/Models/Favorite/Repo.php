<?php

namespace App\Models\Favorite;

use App\Database\Db;
use App\Models\AbstractModel;

class Repo extends AbstractModel
{
    protected static function getTable(): string
    {
        return 'favorites';
    }

    protected function applyCustomFilters(Db $query, array $params): void
    {
    }

    protected function executeQuery(Db $query, array $params): ?array
    {
        $list = $query->exec()->list();
        return $list ?: null;
    }

    public function insertOrUpdate(array $params)
    {
        // Вставляем или обновляем запись и сразу получаем ID
        return $this->db->insert(static::getTable(), $params)->id();
    }
}