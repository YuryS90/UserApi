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

        $this->insert(self::REPO_CATEGORY, $collection);

        // Очистка кеша с категориями
        $this->destroyCache(self::KEY_CATEGORIES);

        return ResourceSuccess::make(201, 'Запись добавлена!');
    }
}