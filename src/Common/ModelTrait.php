<?php

namespace App\Common;

trait ModelTrait
{
    use ContainerTrait;

    /**
     * Получение списка (все записи) или текущей записи из одной таблицы БД
     * @throws \Exception
     */
    public function getAllOrById(string $repository, ?int $id = null): ?array
    {
        // TODO getListOrRecordById Получение списка (все записи) или записи по id
        $this->hasRepo($repository);

        if (isset($id)) {
            // Запись по id
            return $this->{$this->getRepoName($repository)}
                ->filter($this->getByIdOption($id));
        }

        // {$this->getRepoName($repository)} - обращение к свойству, напр. $this->tagRepo->filter()
        // Весь список
        return $this->{$this->getRepoName($repository)}->filter(['is_del' => 0]);
    }

    public function getRecordByField(string $repository, array $param): ?array
    {
        $this->hasRepo($repository);

        if (!isset($param)) {
            return null;
        }

        return $this->{$this->getRepoName($repository)}->filter(array_merge($param, [
            'is_del' => 0,
            'single' => true
        ]));

    }

    /**
     * Получаем список взависимости от переданных параметров из одной или нескольких таблиц БД
     * @throws \Exception
     */
    public function listByParams(string $repository, array $params = []): ?array
    {
        // TODO поменять на getJoinList - Получаем список из нескольких таблиц БД

        $this->hasRepo($repository);

        // Получение данных из таблиц users и user_roles
        if (isset($params['usersJoin'])) {
            if (isset($params['id'])) {
                return $this->{$this->getRepoName($repository)}
                    ->filter(array_merge($this->getRoleOption(), $this->getByIdOption($params['id'])));
            }
            return $this->{$this->getRepoName($repository)}
                ->filter(array_merge($this->getRoleOption(), ['is_del' => 0]));
        }

        // TODO Вынести отдельным методом, т.к. результат не является списком
        if (isset($params['column'])) {
            return $this->{$this->getRepoName($repository)}
                ->filter($this->getSchemaOption());
        }

        return null;
    }

    /** @throws \Exception */
    public function insert(string $repository, array $payload): void
    {
        $this->hasRepo($repository);

        if (empty($payload)) {
            return;
        }

        $this->{$this->getRepoName($repository)}->insertOrUpdate($payload);
    }

    /**
     * Вставить и получить запись
     * @throws \Exception
     */
    public function insertGet(string $repository, array $param, array $data): ?array
    {
        $this->insert($repository, $data);

        return $this->getRecordByField($repository, $param);
    }

    /** @throws \Exception */
    public function update(string $repository, array $payload): void
    {
        $this->hasRepo($repository);

        if (empty($payload)) {
            return;
        }

        $this->{$this->getRepoName($repository)}->insertOrUpdate($payload);
    }

    /** @throws \Exception */
    public function delete(string $repository, int $id): void
    {
        if (empty($id)) {
            return;
        }

        $this->hasRepo($repository);
        $this->{$this->getRepoName($repository)}->insertOrUpdate([
            'id' => $id,
            'is_del' => 1,
        ]);
    }

    public function buildTree(array $list, int $parentId = 0): ?array
    {
        if (!$list) {
            return null;
        }

        $branch = [];
        foreach ($list as $node) {

            if ($node['parentId'] == $parentId) {
                $parent = $this->buildTree($list, $node['id']);

                if ($parent) {
                    $node['childs'] = $parent;
                }
                $branch[] = $node;
            }
        }
        return $branch;
    }

    /** Преобразование в древовидный массив */
    public function buildTree2(array $list): ?array
    {
        if (!$list) {
            return null;
        }

        // Формирование дерева категорий
        $tree = [];
        foreach ($list as $id => &$node) {
            // Если это родительская категория (parentId = 0), то помещаем в корень
            if (!$node['parentId']) {
                $tree[$id] = &$node;
            } else {
                // Иначе формируем дочерний элемент
                $list[$node['parentId']]['childs'][$id] = &$node;
            }
        }

        return $tree;
    }

    public function getCurrent(array $data, int $id): ?array
    {
        return $data[$id];
    }

    private function getRepoName(string $repository): string
    {
        return $repository . 'Repo';
    }

    /** @throws \Exception */
    private function hasRepo(string $repository): void
    {
        $repo = $this->getRepoName($repository);

        if (!$this->container->has($repo)) {
            throw new \Exception("Репозиторий {$repo} отсутствует");
        }
    }

    /** Установка порядка полей таблиц */
    public function setFieldOrder(array $columns, string $key): array
    {
        // Формирование в одномерный ассоциативный массив (поля в разнобой)
        $fields = [];
        foreach ($columns as $value) {
            $fields[$value["cOLUMNNAME"]] = $value["cOLUMNCOMMENT"];
        }

        // Нужный порядок полей таблицы
        $desiredOrder = !empty($_ENV[$key]) ? unserialize($_ENV[$key]) : [];

        // Получаем поля в нужном порядке
        uksort($fields, function ($a, $b) use ($desiredOrder) {
            $aIndex = array_search($a, $desiredOrder);
            $bIndex = array_search($b, $desiredOrder);
            return $aIndex - $bIndex;
        });

        return $fields;
    }

    private function getSchemaOption(): array
    {
        return [
            'fields' => ['COLUMN_COMMENT', 'COLUMN_NAME'],
            'TABLE_SCHEMA' => true,
            'TABLE_NAME' => true,
            'COLUMN_NAME' => ['password', 'is_del', 'created', 'updated'],
        ];
    }

    private function getByIdOption(int $id): array
    {
        return [
            'id' => $id,
            'is_del' => 0,
            'single' => true
        ];
    }

    private function getRoleOption(): array
    {
        return [
            'joinRole' => [
                'fields' => ['id_role', 'name_role']
            ],
        ];
    }
}