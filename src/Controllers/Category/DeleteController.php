<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

/** Удаление */
class DeleteController extends AbstractController
{
    /** @throws \Exception */
    protected function run(): Response
    {
        $categories = $this->cache([
            'key' => self::KEY_CATEGORIES,
            'repo' => self::REPO_CATEGORY,
        ]);

        foreach ($categories as $category) {
            if ($category['parentId'] == $this->id) {
                return ResourceError::make(202, 'Невозможно удалить родительскую категорию');
            }
        }

        // "Удаление" записи из БД
        $this->delete(self::REPO_CATEGORY, $this->id);

        // Удаление файла кеша чтобы обновился весь список для IndexController
        $this->destroyCache(self::KEY_CATEGORIES);

        return ResourceSuccess::make(200, 'Запись удалена!');
    }
}