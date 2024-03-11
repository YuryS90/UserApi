<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Удаление
 * @property mixed|null $id
 */
class DeleteController extends AbstractController
{
    /** @throws \Exception */
    protected function run(): Response
    {
        foreach ($this->getCacheCategories(self::CACHE_CATEGORY_LIST, true) as $item) {
            if ($item['parentId'] == $this->id) {
                return ResourceError::make(202, 'Невозможно удалить родительскую категорию');
            }
        }

        // "Удаление" записи из БД
        $this->delete(self::CATEGORY, $this->id);

        // Удаление файла кеша чтобы обновился весь список для IndexController
        $this->destroyCache(self::CACHE_TREE);
        $this->destroyCache(self::CACHE_CATEGORY_LIST);

        return ResourceSuccess::make(200, 'Запись удалена!');
    }
}