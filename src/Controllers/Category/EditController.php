<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Отображение формы на редактирование
 * @property mixed|null $id
 */
class EditController extends AbstractController
{
    private string $template = 'category/edit.twig';

    /** @throws \Exception */
    protected function run(): Response
    {
        //$this->dd($this->getAllOrSingle(self::CATEGORY, $this->id));
        // array:6 [▼
        //  "id" => 20
        //  "parentId" => 16
        //  "title" => "Звери"
        //  "isDel" => 0
        //  "created" => "2023-12-15 22:06:25"
        //  "updated" => null
        //]

        return $this->render($this->template, [
            'categories' => $this->getCacheCategories(self::CACHE_TREE) ?? [],
            'categoryCurrent' => $this->getAllOrSingle(self::CATEGORY, $this->id) ?? [],
        ]);
    }
}