<?php

namespace App\Models\OrderItem;

use App\Database\Db;
use App\Models\AbstractModel;

class Repo extends AbstractModel
{
    protected static function getTable(): string
    {
        return 'order_items';
    }

    protected function applyCustomFilters(Db $query, array $params): void
    {
        if (isset($params['order_id'])) {
            $query->where('order_id=%s', $params['order_id']);
        }
    }

    protected function executeQuery(Db $query, array $params): ?array
    {
        $list = $query->exec()->listCamelCase('id');

        if (!$list) {
            return null;
        }

        if (isset($params['joinProduct'])) {
            $list = $this->joinProduct($list, $params['joinProduct']);
        }

        return $list;
    }

    public function joinProduct(array $list, array $params): array
    {

        // Получаю всех пользователей
        $products = $this->testRepo->filter(array_merge($params, ['camel' => true]));

        // $list содержит текущие заказы
        foreach ($list as &$item) {
            // Проверяем, существует ли продукт с таким testId в массиве $products
            if (isset($products[$item["testId"]])) {
                // Сохраняем данные продукта
                $product = $products[$item["testId"]];

                // Заменяем testId на title и price
                $item["title"] = $product["title"];
                $item["price"] = $product["price"];

                // Убираем ненужный testId
                unset($item["testId"]);
            }
        }

        return $list;
    }
}