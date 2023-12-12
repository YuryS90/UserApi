<?php

namespace App\Models\User\Field;

use App\Models\Model;

/**
 * @property mixed|null $db
 */
class Repo extends Model
{
    const TABLE_INFO = 'information_schema.COLUMNS';
    const TABLE_DB = 'users';

    public function insertOrUpdate(array $params): void
    {
    }

    /**
     * Универсальная выборка
     * @return false|mixed|null
     */
    public function filter(array $params)
    {
        // Выборка по конкретным полям либо по всем
        $fields = !empty($params['fields']) ? implode(',', $params['fields']) : '*';

        $q = $this->db->build("SELECT {$fields} FROM " . self::TABLE_INFO);

        if ($params['TABLE_SCHEMA']) {
            $q->where('TABLE_SCHEMA=%s', $_ENV['DB_DATABASE']);
        }

        if ($params['TABLE_NAME']) {
            $q->where('TABLE_NAME=%s', self::TABLE_DB);
        }

        if (!empty($params['COLUMN_NAME'])) {
            $q->where('COLUMN_NAME NOT IN(%ls)', $params['COLUMN_NAME']);
        }

        if (!$list = $q->exec()->listCamelCase('COLUMN_COMMENT')) {
            return null;
        }

        return !empty($params['single']) ? current($list) : $list;
    }
}