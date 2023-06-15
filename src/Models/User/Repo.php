<?php

namespace App\Models\User;

use App\Models\Model;

class Repo extends Model
{
    protected string $table = 'users';

    // Универсальный метод
    public function filter($params)
    {
        // Выборка по конкретным полям либо по всем
        $fields = !empty($params['fields']) ? implode(',', $params['fields']) : '*';

        $q = $this->db->build("SELECT {$fields} FROM {$this->table}");

        // Выборка либо по `id`
        if (!empty($params['id'])) {
            $q->where('id=%s', $params['id']);
        }

        // Выборка либо по `email`
        if (!empty($params['email'])) {
            $q->where('email=%s', $params['email']);
        }

        // Выборка либо по `login`
        if (!empty($params['login'])) {
            $q->where('login=%s', $params['login']);
        }

        // Если COUNT(*)
        if ($params['count']) {
            return $q->exec()->result();
        }

        if (!$list = $q->exec()->listCamelCase('id')) {
            return null;
        }

        return !empty($params['single']) ? current($list) : $list;
    }
}