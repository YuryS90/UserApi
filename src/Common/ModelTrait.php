<?php

namespace App\Common;

trait ModelTrait
{
    use ContainerTrait;

    /** @throws \Exception */
    public function getAllOrSingle(string $repository, ?int $id = null): array
    {
        $this->hasRepo($repository);

        if (empty($id)) {
            // Возвращает все элементы
            return $this->{$this->getRepoName($repository)}->filter(['is_del' => 0]);
        }

        // Возвращает текущий элемент
        return $this->{$this->getRepoName($repository)}->filter([
            'id' => $id,
            'is_del' => 0,
            'single' => true
        ]);
    }

    /** @throws \Exception */
    public function insert(string $repository, array $payload): void
    {
        if (empty($payload)) {
            return;
        }

        $this->hasRepo($repository);
        $this->{$this->getRepoName($repository)}->insertOrUpdate($payload);
    }

    /** @throws \Exception */
    public function update(string $repository, array $payload): void
    {
        if (empty($payload)) {
            return;
        }

        $this->hasRepo($repository);
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


}