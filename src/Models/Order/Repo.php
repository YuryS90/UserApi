<?php

namespace App\Models\Order;

use App\Database\Db;
use App\Models\AbstractModel;

class Repo extends AbstractModel
{
    protected static function getTable(): string
    {
        return 'orders';
    }

    protected function applyCustomFilters(Db $query, array $params): void
    {
    }

    protected function executeQuery(Db $query, array $params): ?array
    {
        $list = $query->exec()->listCamelCase('id');

        if (!$list) {
            return null;
        }

        if (isset($params['joinUser'])) {
            $list = $this->joinUser($list, $params['joinUser']);
        }

        if (isset($params['joinStatus'])) {
            $list = $this->joinStatus($list, $params['joinStatus']);
        }

        return $list;
    }

    public function insertOrUpdate(array $params)
    {
        // Вставляем или обновляем запись и сразу получаем ID
        return $this->db->insert(static::getTable(), $params)->id();
    }

    public function joinUser(array $list, array $params): array
    {
        // Получаю всех пользователей
        $users = $this->userRepo->filter($params);

        // $list содержит все заказы
        foreach ($list as &$item) {
            if (isset($users[$item["userId"]])) {
                // Заменяем userId на email
                $user = $users[$item["userId"]];
                $item["userId"] = $user["email"];

                // Добавляем адрес пользователя
                $item["address"] = empty($user["address"]) ? 'Не добавлен!' : $user["address"];
            }
        }

        return $list;
    }

    public function joinStatus(array $list, array $params): array
    {
        // Получаю всех пользователей
        $statuses = $this->statusRepo->filter($params);

        // $list содержит все заказы
        foreach ($list as &$item) {
            // Поиск в списке статусов (по ключу массива) id статус в заказе
            if (isset($statuses[$item["statusId"]])) {
                // Присваиваем вместо userId почту
                $item["statusId"] = $statuses[$item["statusId"]]["stName"];
            }
        }

        return $list;
    }
}