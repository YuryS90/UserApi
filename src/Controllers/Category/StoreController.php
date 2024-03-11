<?php

namespace App\Controllers\Category;

use App\Controllers\AbstractController;
use App\resources\ResourceError;
use App\resources\ResourceSuccess;
use Psr\Http\Message\ResponseInterface as Response;

/** Добавление новой записи */
class StoreController extends AbstractController
{
    /** @throws \Exception */
    protected function run(): Response
    {
        // Получение данных
        $request = $this->request->getParsedBody();

        // Их обработка
        $collection = $this->sanitization($request);
        $error = $this->validated($collection);

        if (!empty($error)) {
            return ResourceError::make(202, $error);
        }

        $this->insert(self::CATEGORY, $collection);

        // Удаление файлов кеша
        $this->destroyCache(self::CACHE_TREE);
        $this->destroyCache(self::CACHE_CATEGORY_LIST);

        return ResourceSuccess::make(201, 'Запись добавлена!');
    }
}