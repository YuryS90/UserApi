<?php

namespace App\Models\Schema;

use App\Models\Model;

class Repo extends Model
{
    const TABLE = 'information_schema.COLUMNS';
    const TABLE_USERS = 'users';
    const DB = 'user_api';

    public function insertOrUpdate(array $params): void
    {
        //$this->db->insert(self::TABLE, $params, true);
    }

    /**
     * Универсальная выборка
     * @return false|mixed|null
     */
    public function filter(array $params)
    {
        // Выборка по конкретным полям либо по всем
        $fields = !empty($params['fields']) ? implode(',', $params['fields']) : '*';

        $q = $this->db->build("SELECT {$fields} FROM " . self::TABLE);

        if ($params['TABLE_SCHEMA']) {
            $q->where('TABLE_SCHEMA=%s', self::DB);
        }

        if ($params['TABLE_NAME']) {
            $q->where('TABLE_NAME=%s', self::TABLE_USERS);
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