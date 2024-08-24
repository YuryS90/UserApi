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

        if (!empty($params['search'])) {
            $q->where('title LIKE %s', "%{$params['search']}%");
        }

        // applyCustomSorting()
        if (!empty($params['orderByIdDesc'])) {
            $q->sql('ORDER BY id DESC');
        }

        if (!empty($params['orderByTitleAsc'])) {
            $q->sql('ORDER BY title ASC');
        }

        if (!empty($params['orderByPriceAsc'])) {
            $q->sql('ORDER BY price ASC');
        }

        if (!empty($params['orderByPriceDesc'])) {
            $q->sql('ORDER BY price DESC');
        }

        // applyCustomLimit()
        if (isset($params['limit']) && isset($params['offset'])) {
            $q->sql('LIMIT %d OFFSET %d', $params['limit'], $params['offset']);
        }

        $list = $this->executeQuery($q, $params);

        return $list === null ? null : (!empty($params['single']) ? current($list) : $list);
    }

    public function getColumnsName(): array
    {
        return $this->db->getColumnsName(static::getTable()) ?: [];
    }

    /**
     * Количество всех записей
     */
    public function getCount(): int
    {
        return $this->db->result("SELECT COUNT(*) FROM " . static::getTable()) ?: 0;
    }
}