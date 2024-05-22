<?php

namespace App\Models\Color;

use App\Models\Model;

class Repo extends Model
{
    const TABLE = 'colors';

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

        // Выборка либо по `id`
        if (!empty($params['id'])) {
            $q->where('id=%s', $params['id']);
        }

        // Если COUNT()
        //if ($params['count']) {
        //    return $q->exec()->result();
        //}

        if (!$list = $q->exec()->listCamelCase('id')) {
            return null;
        }

        return !empty($params['single']) ? current($list) : $list;
    }
}