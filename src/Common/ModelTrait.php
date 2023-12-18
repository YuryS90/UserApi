<?php

namespace App\Common;

trait ModelTrait
{
    use HelperTrait;

    public function getCategories(): array
    {
        $list = $this->categoryRepo->filter([
                'fields' => ['id', 'parent_id', 'title'],
                'is_del' => 0
            ]) ?? [];

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

    public function getCategory($id)
    {
       //$category = $this->categoryRepo->filter([
       //    'id' => $id,
       //    'is_del' => 0,
       //    'single' => true
       //]);


        //$this->dd($categories, 1);
    }

}