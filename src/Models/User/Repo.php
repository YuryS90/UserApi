<?php

namespace App\Models\User;

use App\Database\Db;
use App\Models\AbstractModel;

/**
 * @property mixed|null $roleRepo
 */
class Repo extends AbstractModel
{
    protected static function getTable(): string
    {
        return 'users';
    }

    protected function applyCustomFilters(Db $query, array $params): void
    {
        if (isset($params['email'])) {
            $query->where('email=%s', $params['email']);
        }
    }

    protected function executeQuery(Db $query, array $params): ?array
    {
        $list = $query->exec()->listCamelCase('id');

        if (!$list) {
            return null;
        }

        if (isset($params['joinRole'])) {
            $list = $this->joinRole($list, $params['joinRole']);
        }

        return $list;
    }

    public function joinRole(array $list, array $params): array
    {
        $roles = $this->roleRepo->filter($params);

        foreach ($list as &$item) {
            // Проверяем, есть ли соответствующая роль во втором массиве
            if (isset($roles[$item["rolesId"]])) {
                $item["rolesId"] = $roles[$item["rolesId"]]["nameRole"];
            }
        }

        return $list;
    }

   //public function getColumnsName(): array
   //{
   //    return parent::getColumnsName(); // TODO: Change the autogenerated stub
   //}
}