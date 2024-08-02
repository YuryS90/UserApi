<?php

namespace App\Models;

use App\Common\ContainerTrait;
use App\Common\ServiceTrait;
use App\Database\Db;

/**
 * @property mixed|null $db
 */
abstract class AbstractModel implements ModelInterface
{
    use ContainerTrait, ServiceTrait;

    abstract protected static function getTable(): string;

    abstract protected function applyCustomFilters(Db $query, array $params): void;

    abstract protected function executeQuery(Db $query, array $params): ?array;

    public function insertOrUpdate(array $params): void
    {
        $this->db->insert(static::getTable(), $params, true);
    }

    public function filter(array $params): ?array
    {
        // Выборка по конкретным полям либо по всем
        $fields = !empty($params['fields']) ? implode(',', $params['fields']) : '*';

        $q = $this->db->build("SELECT {$fields} FROM " . static::getTable());

        // Выборка либо по `id`
        if (isset($params['id'])) {
            $q->where('id=%s', $params['id']);
        }

        // Выборка по пользовательским параметрам
        $this->applyCustomFilters($q, $params);

        // Выборка по `is_del`
        if (isset($params['is_del']) && $params['is_del'] === 0) {
            $q->where('is_del=%s', $params['is_del']);
        }

        $list = $this->executeQuery($q, $params);

        return $list === null ? null : (!empty($params['single']) ? current($list) : $list);
    }

    public function getColumnsName(): array
    {
        return $this->db->getColumnsName(static::getTable());
    }
}