<?php

namespace App\Models\Role;

use App\Models\Model;

class Repo extends Model
{
    const TABLE = 'user_roles';

    /**
     * Добавить или обновить данные
     * @throws \ErrorException
     */
    public function insertOrUpdate(array $params): void
    {
        $this->db->insert(self::TABLE, $params, true);
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

        if (!$list = $q->exec()->listCamelCase('id_role')) {
            return null;
        }

        return !empty($params['single']) ? current($list) : $list;
    }
}