<?php

namespace App\Models\User;

use App\Models\Model;

class Repo extends Model
{
    protected string $table = 'users';
    private array $data = [];

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    const USER_ROLE = 3;

    public function insertOrUpdate(array $params)
    {
        $this->insertPreparation($params);
        $this->db->insert($this->table, $this->data, true);
    }

    // Универсальный метод
    public function filter(array $params)
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

    // Подготовка к вставке
    private function insertPreparation(array $params): void
    {
        // Важно чтобы данные не кешировались -
        // при регистрации второго пользователя не попали данные первого
        $this->data = [];

        $this->data += [
            'login' => $params['login'],
            'email' => $params['email'],
            'pwd' => password_hash($this->genClass->password(12), PASSWORD_DEFAULT),
            'roles_id' => self::USER_ROLE
        ];
    }
}