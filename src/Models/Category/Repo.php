<?php

namespace App\Models\Category;

use App\Models\Model;

/**
 * @property mixed|null $db
 */
class Repo extends Model
{
    const TABLE = 'categories';

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

        // Выборка по `is_del`
        if ($params['is_del'] === 0) {
            $q->where('is_del=%s', $params['is_del']);
        }

        if (!$list = $q->exec()->listCamelCase('id')) {
            return null;
        }

        return !empty($params['single']) ? current($list) : $list;
    }
}