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

    protected function run(): Response
    {//$this->dd($this->getCategory($this->id), $this->getCategories());
        return $this->render($this->template, [
            'categories' => $this->getCategories() ?? [],
            'categoryCurrent' => $this->getCategory($this->id) ?? [],
        ]);
    }
}