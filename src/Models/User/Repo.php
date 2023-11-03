<?php

namespace App\Models\User;

use App\Models\Model;

class Repo extends Model
{
    //private array $data = [];

    const TABLE = 'users';
    //const USER_ROLE = 3;

    /**
     * Добавить или обновить данные пользователя
     * @throws \ErrorException
     */
    public function insertOrUpdate(array $params): void
    {
//        $this->preparationData($params);
//
//        $data = $this->getData();
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
//
//        // Выборка либо по `email`
//        if (!empty($params['email'])) {
//            $q->where('email=%s', $params['email']);
//        }

        // Выборка по `is_del`
        if ($params['is_del'] === 0) {
            $q->where('is_del=%s', $params['is_del']);
        }

//        // Выборка либо по `login`
//        if (!empty($params['login'])) {
//            $q->where('login=%s', $params['login']);
//        }

//        // Если COUNT()
//        if ($params['count']) {
//            return $q->exec()->result();
//        }

        if (!$list = $q->exec()->listCamelCase('id')) {
            return null;
        }

        return !empty($params['single']) ? current($list) : $list;
    }

    /** Подготовка к вставке */
//    private function preparationData(array $params): void
//    {
//        if (!empty($params['id'])) {
//            $this->setData($params);
//        }
//
//        if (empty($params['id'])) {
//            // Важно чтобы данные не кешировались -
//            // при регистрации второго пользователя не попали данные первого
//            $this->setData([
//                'login' => $params['login'],
//                'email' => $params['email'],
//                'pwd' => password_hash($params['pwd'], PASSWORD_DEFAULT),
//                //'pwd' => $params['pwd'],
//                'roles_id' => self::USER_ROLE
//            ]);
//        }
//    }
//
//    public function getData(): array
//    {
//        return $this->data;
//    }
//
//    public function setData(array $data): void
//    {
//        $this->data = $data;
//    }
}